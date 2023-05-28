<?php

namespace App\Http\Dto\Config;

use Cblink\Dto\Dto;

/**
 * @property integer $type 类型
 * @property string $secret_key api秘钥
 * @property string $key_type 类型
 */
class GptSecretKeyDto extends Dto implements ConfigDtoInterface
{
    const GPTLINK = 'gptlink';
    const OPENAI = 'openai';

	protected $fillable = [
		'name', 'type', 'key_type', 'secret_key', 'icp', 'web_logo', 'admin_logo'
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
