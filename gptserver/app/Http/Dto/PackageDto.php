<?php

namespace App\Http\Dto;

use App\Model\Order;
use App\Model\Package;
use Cblink\Dto\Dto;
use Hyperf\Snowflake\IdGeneratorInterface;

/**
 *
 */
class PackageDto extends Dto
{
    protected $fillable = [
        'name', 'code', 'show_name', 'sort', 'num', 'price', 'level', 'show',
    ];

    /**
     * @return array
     */
    public function toData(): array
    {
        if ($this->getItem('code') == Package::CODE_NUM) {
            $expired_day = 0;
            $num = $this->getItem('num');
        } else {
            $expired_day = $this->getItem('num');
            $num = -1;
        }

        return [
            'name' => $this->getItem('name'),
            'type' => Package::TYPE_CHAT,
            'code' => $this->getItem('code'),
            'identity' => Package::IDENTITY_USER,
            'show_name' => $this->getItem('show_name'),
            'sort' => $this->getItem('sort'),
            'expired_day' => $expired_day,
            'num' => $num,
            'price' => $this->getItem('price'),
            'level' => $this->getItem('level'),
            'show' => Package::SHOW_OFF,
        ];
    }

    public function getUpdateData()
    {
        if ($this->getItem('code') == Package::CODE_NUM) {
            $expired_day = 0;
            $num = $this->getItem('num');
        } else {
            $expired_day = $this->getItem('num');
            $num = -1;
        }

        return [
            'name' => $this->getItem('name'),
            'code' => $this->getItem('code'),
            'show_name' => $this->getItem('show_name'),
            'sort' => $this->getItem('sort'),
            'expired_day' => $expired_day,
            'num' => $num,
            'price' => $this->getItem('price'),
            'level' => $this->getItem('level'),
        ];
    }

}
