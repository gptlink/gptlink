<?php

namespace App\Http\Dto;

use App\Model\Member;
use Cblink\HyperfExt\Dto;
use Hyperf\Utils\Str;

/**
 * @property null|string $share_openid
 */
class MemberDto extends Dto
{
    protected $fillable = [
        'nickname',
        'avatar',
        'mobile',
        'source',
        'share_openid',
        'account_type',
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
            'account_type' => $this->getItem('account_type', Member::ACCOUNT_MOBILE),
            'parent_openid' => $this->getItem('share_openid'),
        ];
    }
}
