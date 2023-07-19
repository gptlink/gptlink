<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\Dto\Dto;

class ShareConfigDto extends Dto implements ConfigDtoInterface
{
    protected $fillable = ['type', 'title', 'desc', 'img_url', 'share_img'];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'type' => $this->getItem('type'),
            'title' => $this->getItem('title'),
            'desc' => $this->getItem('desc'),
            'img_url' => $this->getItem('img_url'),
            'share_img' => $this->getItem('share_img'),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'title' => $this->getItem('title'),
                'desc' => $this->getItem('desc'),
                'img_url' => $this->getItem('img_url'),
                'share_img' => $this->getItem('share_img'),
            ],
        ];
    }

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array
    {
        return [
            'type' => $this->getItem('type', Config::SHARE),
        ];
    }
}
