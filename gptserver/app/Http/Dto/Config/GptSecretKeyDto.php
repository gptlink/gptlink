<?php

namespace App\Http\Dto\Config;

use Cblink\Dto\Dto;

/**
 * @property integer $type 类型
 * @property string $secret_key api秘钥
 */
class GptSecretKeyDto extends Dto implements ConfigDtoInterface
{
	protected $fillable = [
		'type', 'secret_key', 'icp', 'web_logo', 'admin_logo'
	];

	/**
	 * 默认数据
	 * @return array
	 */
	public function getDefaultConfig(): array
	{
		return [
			'type'    => $this->getItem('type'),
			'secret_key'   => $this->getItem('secret_key'),
            'icp'   => $this->getItem('icp'),
            'web_logo'   => $this->getItem('web_logo'),
            'admin_logo'   => $this->getItem('admin_logo'),
		];
	}

	/**
	 * 更新或创建时的数据.
	 */
	public function getConfigFillable(): array
	{
		return [
			'config' => [
				'secret_key'   => $this->getItem('secret_key'),
                'icp'   => $this->getItem('icp'),
                'web_logo'   => $this->getItem('web_logo'),
                'admin_logo'   => $this->getItem('admin_logo'),
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
