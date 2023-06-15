<?php

namespace App\Http\Dto\Config;


use App\Model\Config;
use Cblink\Dto\Dto;

/**
 * @property $title
 * @property $agreement
 */
class ProtocolDto extends Dto implements ConfigDtoInterface
{
    protected $fillable = ['type', 'enable', 'title', 'agreement'];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'type'    => $this->getItem('type'),
            'enable' => $this->getItem('enable', true),
            'title'    => $this->getItem('title'),
            'agreement'    => $this->getItem('agreement'),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'enable' => $this->getItem('enable', true),
                'title'    => $this->getItem('title'),
                'agreement'    => $this->getItem('agreement'),
            ]
        ];
    }

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array
    {
        return [
            'type' => $this->getItem('type', Config::PROTOCOL),
        ];
    }
}
