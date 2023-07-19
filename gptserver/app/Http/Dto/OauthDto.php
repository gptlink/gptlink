<?php

namespace App\Http\Dto;

use Cblink\HyperfExt\Dto;

/**
 * @property string $nickname 名称
 * @property string $avatar 头像
 * @property string $openid 时间
 * @property string $unionid 优先级
 * @property string $platform 平台
 * @property string $appid 公众平台
 */
class OauthDto extends Dto
{
    protected $fillable = [
        'nickname',
        'avatar',
        'openid',
        'unionid',
        'platform',
        'member_id',
        'appid',

        'share_openid',
        'source',
    ];

    /**
     * @param mixed $memberId
     * @return array
     */
    public function getOauthData($memberId = 0)
    {
        return [
            'member_id' => $memberId ?: 0,
            'nickname' => $this->getItem('nickname'),
            'avatar' => $this->getItem('avatar'),
            'unionid' => $this->getItem('unionid'),
            'openid' => $this->getItem('openid'),
            'platform' => $this->getItem('platform'),
            'appid' => $this->getItem('appid'),
        ];
    }
}
