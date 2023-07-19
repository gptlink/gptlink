<?php

namespace App\Http\Dto;

use Cblink\HyperfExt\Dto;

/**
 * @property string $mobile 注册的手机号
 * @property null|string $share_openid 分享人ID
 * @property null|string $source 注册来源，自定义标识
 */
class MemberRegisterDto extends Dto
{
    protected $fillable = [
        'mobile',
        'share_openid',
        'source',
    ];
}
