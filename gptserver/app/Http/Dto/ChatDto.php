<?php

namespace App\Http\Dto;

use App\Base\Consts\ModelConst;
use App\Http\Dto\Config\AiChatConfigDto;
use App\Http\Service\ChatGPTService;
use Carbon\Carbon;
use Cblink\Dto\Dto;
use Gioni06\Gpt3Tokenizer\Gpt3Tokenizer;
use Psr\SimpleCache\InvalidArgumentException;

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
    public function toGPTLink(AiChatConfigDto $config)
    {
        $system = $this->getItem('system') ?: $config->default_system_prompt;

        return [
            'model' => ModelConst::GPT_35_TURBO,
            'temperature' => $this->getItem('temperature', 0.8),
            'top_p' => $this->getItem('top_p', 1),
            'stream' => true,
            'presence_penalty' => $this->getItem('presence_penalty', 1),
            'system_prompt' => $system,
            'prompt' => $this->getItem('message'),
            'last_message_id' => $this->getItem('last_id'),
        ];
    }

    public function toOpenAi(AiChatConfigDto $config)
    {
        return [
            'model' => $config->openai_model,
            'temperature' => $this->getItem('temperature', 0.8),
            'top_p' => $this->getItem('top_p', 1),
            'stream' => true,
            'presence_penalty' => $this->getItem('presence_penalty', 1),
            'max_tokens' => (int) $config->openai_tokens,
            'messages' => $this->getMessage($config),
        ];
    }

    /**
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getMessage(AiChatConfigDto $config)
    {
        $messages = [];

        $system = $this->getItem('system') ?: $config->default_system_prompt;
        $systemTokens = $system ? app()->get(Gpt3Tokenizer::class)->count($system) : 0;

        $this->getLastMessages($config, $this->getItem('last_id'), $messages, $systemTokens);

        $messages = array_reverse($messages);

        $messages[] = ['role' => 'user', 'content' => $this->getItem('message')];

        if ($system) {
            array_unshift($messages, ['role' => 'system', 'content' => $system]);
        }

        return $messages;
    }

    /**
     * @param AiChatConfigDto $configDto
     * @param $lastId
     * @param array $messages
     * @param int $totalTokens
     * @param int $count
     * @return void
     * @throws InvalidArgumentException
     */
    public function getLastMessages(AiChatConfigDto $configDto, $lastId, array &$messages = [], int $totalTokens = 0, int $count = 8)
    {
        if (! $lastId || ! $message = cache()->get('chat-'. $lastId)) {
            return;
        }

        if ($count-- <= 0) {
            return;
        }

        $totalTokens += ($message['tokens'] ?: 0);

        $maxTokens = bcsub(
            (string) $configDto->openai_tokens,
            (string) $configDto->openai_response_tokens
        );

        if ($totalTokens >= $maxTokens) {
            return;
        }

        $messages[] = ['role' => 'assistant', 'content' => $message['result']];
        $messages[] = ['role' => 'user', 'content' => $message['message']];

        if ($message['last_id']) {
            $this->getLastMessages($configDto, $message['last_id'], $messages, $totalTokens, $count);
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
