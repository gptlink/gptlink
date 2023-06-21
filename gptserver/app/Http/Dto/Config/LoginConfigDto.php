<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\Dto\Dto;

/**
 * @property  int $login_type 登录方式
 * @property int $mobile_verify 是否验证手机号
 */
class LoginConfigDto extends Dto implements ConfigDtoInterface
{
    const LOGIN_TYPE_USERNAME = 1;
    const LOGIN_TYPE_WECHAT = 2;
    const LOGIN_TYPE = [
        self::LOGIN_TYPE_USERNAME => '用户名密码',
        self::LOGIN_TYPE_WECHAT => '微信登陆',
    ];

    protected $fillable = ['type', 'login_type', 'mobile_verify'];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'type'    => $this->getItem('type'),
            'login_type' => $this->getItem('login_type'),
            'mobile_verify' => $this->getItem('mobile_verify', false),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'login_type' => $this->getItem('login_type'),
                'mobile_verify' => $this->getItem('mobile_verify', false),
            ]
        ];
    }

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array
    {
        return [
            'type' => $this->getItem('type', Config::LOGIN),
        ];
    }
}
