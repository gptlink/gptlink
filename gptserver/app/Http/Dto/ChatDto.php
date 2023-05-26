<?php

namespace App\Http\Dto;

use App\Base\Consts\ModelConst;
use App\Http\Service\ChatGPTService;
use Carbon\Carbon;
use Cblink\Dto\Dto;
use Psr\SimpleCache\InvalidArgumentException;

/**
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
        $messages[] = ['role' => 'system', 'content' => $this->getItem('system')];
        $messages[] = ['role' => 'user', 'content' => $this->getItem('message')];

        return [
            'model' => $this->getItem('model', ModelConst::GPT_35_TURBO),
            'temperature' => $this->getItem('temperature', 0.8),
            'top_p' => $this->getItem('top_p', 1),
            'stream' => $this->getItem('stream', true),
            'presence_penalty' => $this->getItem('presence_penalty', 1),
            'max_tokens' => 1000,
            'messages' => $messages,
        ];
    }
}
