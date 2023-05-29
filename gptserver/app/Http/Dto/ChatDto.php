<?php

namespace App\Http\Dto;

use App\Base\Consts\ModelConst;
use App\Http\Service\ChatGPTService;
use Carbon\Carbon;
use Cblink\Dto\Dto;
use Gioni06\Gpt3Tokenizer\Gpt3Tokenizer;

/**
 * @property string $message 提示词
 * @property bool $stream 是否已数据流格式返回
 *
 * @property string $format_before
 * @property string $format_after
 */
class ChatDto extends Dto
{
    const MAX_MODEL_TOKENS = 3800;
    const MAX_RESPONSE_TOKEN = 1000;

    protected $fillable = [
        'model',
        'message',
        'system',
        'last_id',
        'temperature',
        'top_p',
        'presence_penalty',
        'frequency_penalty',

        'stream',
        'cached',

        'format_before',
        'format_after',
    ];

    public function formatAfter()
    {
        return $this->getItem('format_after', '');
    }

    public function formatBefore()
    {
        return $this->getItem('format_before', '');
    }

    /**
     * @return array
     */
    public function toGPTLink()
    {
        return [
            'model' => $this->getItem('model', ModelConst::GPT_35_TURBO),
            'temperature' => $this->getItem('temperature', 0.8),
            'top_p' => $this->getItem('top_p', 1),
            'stream' => $this->getItem('stream', true),
            'presence_penalty' => $this->getItem('presence_penalty', 1),
            'system_prompt' => $this->getItem('system'),
            'prompt' => $this->getItem('message'),
            'last_message_id' => $this->getItem('last_id'),
        ];
    }

    public function toOpenAi()
    {
        return [
            'model' => $this->getItem('model', ModelConst::GPT_35_TURBO),
            'temperature' => $this->getItem('temperature', 0.8),
            'top_p' => $this->getItem('top_p', 1),
            'stream' => $this->getItem('stream', true),
            'presence_penalty' => $this->getItem('presence_penalty', 1),
            'max_tokens' => self::MAX_RESPONSE_TOKEN,
            'messages' => $this->getMessage(),
        ];
    }

    public function getMessage()
    {
        $messages = [];

        $this->getLastMessages($this->getItem('last_id'), $messages);

        $messages = array_reverse($messages);

        $messages[] = ['role' => 'user', 'content' => $this->getItem('message')];

        if ($system = $this->getItem('system')) {
            array_unshift($messages, ['role' => 'system', 'content' => $system]);
        }

        return $messages;
    }

    public function getLastMessages($lastId, array &$messages = [], int $totalTokens = 0, int $count = 8)
    {
        if (! $lastId || ! $message = cache()->get('chat-'. $lastId)) {
            return;
        }

        $totalTokens += ($message['tokens'] ?: 0);

        if ($totalTokens >= (self::MAX_MODEL_TOKENS - self::MAX_RESPONSE_TOKEN)) {
            return;
        }

        if ($count-- <= 0) {
            return;
        }

        $messages[] = ['role' => 'assistant', 'content' => $message['result']];
        $messages[] = ['role' => 'user', 'content' => $message['message']];

        if ($message['last_id']) {
            $this->getLastMessages($message['last_id'], $messages, $totalTokens, $count);
        }
    }

    /**
     * @param $id
     * @param $result
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function cached($id, $result)
    {
        if (!$id) {
            return;
        }

        $string = sprintf("%s %s", $this->getItem('message'), $result);

        $tokenizer = app()->get(Gpt3Tokenizer::class);

        cache()->set(sprintf('chat-%s', $id), [
            'last_id' => $this->getItem('last_id'),
            'message' => $this->getItem('message'),
            'result' => $result,
            'tokens' => count($tokenizer->encode($string)),
        ], 86400);
    }
}
