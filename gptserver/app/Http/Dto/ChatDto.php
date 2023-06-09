<?php

namespace App\Http\Dto;

use App\Base\Consts\ModelConst;
use App\Http\Service\ChatGPTService;
use Carbon\Carbon;
use Cblink\Dto\Dto;
use Gioni06\Gpt3Tokenizer\Gpt3Tokenizer;

/**
 * @property string $model 使用的模型
 * @property string $message 提示词
 * @property bool $stream 是否已数据流格式返回
 *
 * @property string $format_before
 * @property string $format_after
 */
class ChatDto extends Dto
{
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
            'max_tokens' => config('openai.chat.max_response_tokens', 1000),
            'messages' => $this->getMessage(),
        ];
    }

    /**
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getMessage()
    {
        $messages = [];

        $system = $this->getItem('system') ?: sprintf('You are GPTLink, a large language model trained by GPT-LINK. Answer as concisely as possible.\nKnowledge cutoff: %s\nCurrent date: %s', '2021-09-01', Carbon::now()->toDateString());
        $systemTokens = $system ? app()->get(Gpt3Tokenizer::class)->count($system) : 0;

        $this->getLastMessages($this->getItem('last_id'), $messages, $systemTokens);

        $messages = array_reverse($messages);

        $messages[] = ['role' => 'user', 'content' => $this->getItem('message')];

        if ($system) {
            array_unshift($messages, ['role' => 'system', 'content' => $system]);
        }

        return $messages;
    }

    /**
     * @param $lastId
     * @param array $messages
     * @param int $totalTokens
     * @param int $count
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getLastMessages($lastId, array &$messages = [], int $totalTokens = 0, int $count = 8)
    {
        if (! $lastId || ! $message = cache()->get('chat-'. $lastId)) {
            return;
        }

        if ($count-- <= 0) {
            return;
        }

        $totalTokens += ($message['tokens'] ?: 0);

        $maxTokens = bcsub(
            (string) config('openai.chat.max_tokens', 4000),
            (string) config('openai.chat.max_response_tokens', 1000)
        );

        if ($totalTokens >= $maxTokens) {
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
            'tokens' => $tokenizer->count($string),
        ], 86400);
    }
}
