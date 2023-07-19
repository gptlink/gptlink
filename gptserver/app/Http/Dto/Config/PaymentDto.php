<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\HyperfExt\Dto;

/**
 * @property array $channel 渠道
 * @property string $offline 线下收款内容
 */
class PaymentDto extends Dto implements ConfigDtoInterface
{
    public const TYPE_OFFLINE = 'offline';

    public const TYPE_WECHAT = 'wechat';

    public const TYPES = [
        self::TYPE_OFFLINE => '线下支付',
        self::TYPE_WECHAT => '微信支付',
    ];

    protected $fillable = [
        'type', 'channel', 'offline',
    ];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'channel' => $this->getItem('channel'),
            'offline' => $this->getItem('offline'),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'channel' => $this->getItem('channel'),
                'offline' => $this->getItem('offline'),
            ],
        ];
    }

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array
    {
        return [
            'type' => $this->getItem('type', Config::PAYMENT),
        ];
    }
}
