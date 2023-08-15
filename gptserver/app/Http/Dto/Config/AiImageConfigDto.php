<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\Dto\Dto;

/**
 * Class AiImageConfigDto
 * @package App\Http\Dto\Config
 * @property string $type 配置项类型
 * @property string $gptlink_key gpt密钥
 * @property string $gptlink_base_url gpt请求地址
 * @property string $channel 渠道
 */
class AiImageConfigDto extends Dto implements ConfigDtoInterface
{
    protected $fillable = [
        'type', 'gptlink_key', 'gptlink_base_url', 'channel'
    ];

    const CHANNEL_GPT_LINK = 'gptlink';
    /**
     * 配置项类型
     * @var array
     */
    const CHANNEL = [
        self::CHANNEL_GPT_LINK => 'GPT-Link',
    ];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'gptlink_key' => $this->getItem('gptlink_key'),
            'channel' => $this->getItem('channel'),
            'gptlink_base_url' => $this->getItem('gptlink_base_url'),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'gptlink_key' => $this->getItem('gptlink_key'),
                'gptlink_base_url' => $this->getItem('gptlink_base_url'),
                'channel' => $this->getItem('channel'),
            ]
        ];
    }

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array
    {
        return [
            'type' => $this->getItem('type', Config::AI_IMAGE),
        ];
    }
}
