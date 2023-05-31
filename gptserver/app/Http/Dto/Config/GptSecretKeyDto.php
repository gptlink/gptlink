<?php

namespace App\Http\Dto\Config;

use Cblink\Dto\Dto;

/**
 * @property integer $type 类型
 * @property string $secret_key api秘钥
 * @property string $key_type 类型
 * @property string|int $login_type 登陆类型
 */
class GptSecretKeyDto extends Dto implements ConfigDtoInterface
{
    const GPTLINK = 'gptlink';
    const OPENAI = 'openai';

    const LOGIN_TYPE_USERNAME = 1;
    const LOGIN_TYPE_WECHAT = 2;
    const LOGIN_TYPE_MOBILE = 3;

    const LOGIN_TYPE_WECHAT_AND_MOBILE = 4;

	protected $fillable = [
		'type',
        'key_type', 'secret_key',
        'name', 'icp', 'web_logo', 'admin_logo', 'user_logo',
        'login_type',
	];

	/**
	 * 默认数据
	 * @return array
	 */
	public function getDefaultConfig(): array
	{
		return [
            'name' => $this->getItem('name','GPTLink'),
			'type'    => $this->getItem('type'),
            'key_type' => $this->getItem('key_type', self::GPTLINK),
			'secret_key'   => $this->getItem('secret_key'),
            'icp'   => $this->getItem('icp'),
            'web_logo'   => $this->getItem('web_logo'),
            'admin_logo'   => $this->getItem('admin_logo'),
            'user_logo' => $this->getItem('user_logo'),
            'login_type' => $this->getItem('login_type', self::LOGIN_TYPE_WECHAT),
		];
	}

	/**
	 * 更新或创建时的数据.
	 */
	public function getConfigFillable(): array
	{
		return [
			'config' => [
                'name' => $this->getItem('name','GPTLink'),
                'key_type' => $this->getItem('key_type', self::GPTLINK),
				'secret_key'   => $this->getItem('secret_key'),
                'icp'   => $this->getItem('icp'),
                'web_logo'   => $this->getItem('web_logo'),
                'admin_logo'   => $this->getItem('admin_logo'),
                'user_logo' => $this->getItem('user_logo'),
                'login_type' => $this->getItem('login_type', self::LOGIN_TYPE_WECHAT),
			]
		];
	}

	/**
	 * 唯一标识数据.
	 */
	public function getUniqueFillable(): array
	{
		return [
			'type'    => $this->getItem('type'),
		];
	}
}
