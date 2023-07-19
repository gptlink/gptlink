<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\HyperfExt\Dto;

/**
 * @property string $client_id appid
 * @property int $type 类型
 * @property string $client_secret app secret
 */
class WechatWebDto extends Dto implements ConfigDtoInterface
{
    protected $fillable = [
        'client_id', 'type', 'client_secret',
    ];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'type' => $this->getItem('type'),
            'client_id' => $this->getItem('client_id'),
            'client_secret' => $this->getItem('client_secret'),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'client_id' => $this->getItem('client_id'),
                'client_secret' => $this->getItem('client_secret'),
            ],
        ];
    }

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array
    {
        return [
            'type' => $this->getItem('type', Config::WECHAT_WEB),
        ];
    }
}
