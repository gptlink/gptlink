<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\Dto\Dto;

/**
 * @property bool $enable
 * @property string $keywords
 */
class KeywordDto extends Dto implements ConfigDtoInterface
{
    protected $fillable = ['type', 'enable', 'keywords'];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'type'    => $this->getItem('type'),
            'enable'    => $this->getItem('enable'),
            'keywords'    => $this->getItem('keywords'),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'enable'    => $this->getItem('enable'),
                'keywords'    => $this->getItem('keywords'),
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
