<?php

namespace App\Http\Dto;

use App\Model\Member;
use Cblink\HyperfExt\Dto;
use Hyperf\Utils\Str;

class MemberDto extends Dto
{
    protected $fillable = [
        'nickname',
        'avatar',
        'mobile',
        'source',
    ];

    public function getData()
    {
        return [
            'code' => Str::random(),
            'status' => Member::STATUS_NORMAL,
            'nickname' => $this->getItem('nickname'),
            'avatar' => $this->getItem('avatar'),
            'mobile' => $this->getItem('mobile'),
            'platform' => Member::PLATFORM_GPT,
            'source' => $this->getItem('source'),
        ];
    }

    public function getUniqueData()
    {
        return ['mobile' => $this->getItem('mobile')];
    }
}
