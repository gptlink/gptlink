<?php

namespace App\Http\Dto;

use Cblink\HyperfExt\Dto;

class MemberPackageRecordDto extends Dto
{
    protected $fillable = [
        'user_id',
        'package_id',
        'package_name',
        'channel',
        'type',
        'code',
        'expired_day',
        'num',
    ];

    public function toData()
    {
        return [
            'user_id' => $this->getItem('user_id'),
            'package_id' => $this->getItem('package_id'),
            'package_name' => $this->getItem('package_name'),
            'channel' => $this->getItem('channel'),
            'type' => $this->getItem('type'),
            'code' => $this->getItem('code'),
            'expired_day' => $this->getItem('expired_day'),
            'num' => $this->getItem('num'),
        ];
    }
}
