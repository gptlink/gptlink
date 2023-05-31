<?php

namespace App\Http\Dto\Config;

use Cblink\HyperfExt\Dto;

/**
 * @property integer $type 类型
 * @property string $key 支付秘钥
 * @property string $mch_id 商户号
 * @property string $appid 公众号 appid
 */
class WechatPaymentDto extends Dto implements ConfigDtoInterface
{
	protected $fillable = [
		'type', 'mch_id', 'key', 'appid'
	];

	/**
	 * 默认数据
	 * @return array
	 */
	public function getDefaultConfig(): array
	{
		return [
			'type'    => $this->getItem('type'),
			'mch_id'   => $this->getItem('mch_id'),
			'key' => $this->getItem('key'),
			'appid' => $this->getItem('appid'),
		];
	}

	/**
	 * 更新或创建时的数据.
	 */
	public function getConfigFillable(): array
	{
		return [
			'config' => [
				'mch_id'   => $this->getItem('mch_id'),
				'key' => $this->getItem('key'),
				'appid' => $this->getItem('appid'),
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
