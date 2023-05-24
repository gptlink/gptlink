<?php

namespace App\Http\Dto\Config;

use Cblink\Dto\Dto;

/**
 * @property bool $enable 是否开启
 * @property string $account 账号
 * @property int $type 类型
 * @property string $password 密码
 * @property string $sign 签名
 */
class SmsChuangLanDto extends Dto implements ConfigDtoInterface
{
	protected $fillable = [
		'enable', 'account', 'type', 'password', 'sign'
	];

	/**
	 * 默认数据
	 * @return array
	 */
	public function getDefaultConfig(): array
	{
		return [
			'type'    => $this->getItem('type'),
            'enable' => $this->getItem('enable', false),
			'account'    => $this->getItem('account'),
            'password'    => $this->getItem('password'),
            'sign'    => $this->getItem('sign'),
		];
	}

	/**
	 * 更新或创建时的数据.
	 */
	public function getConfigFillable(): array
	{
		return [
			'config' => [
                'enable' => $this->getItem('enable', false),
                'account'    => $this->getItem('account'),
                'password'    => $this->getItem('password'),
                'sign'    => $this->getItem('sign'),
			]
		];
	}

	/**
	 * 唯一标识数据.
	 */
	public function getUniqueFillable(): array
	{
		return [
			'type' => $this->getItem('type'),
		];
	}
}
