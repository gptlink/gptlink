<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\HyperfExt\Dto;

/**
 * @property string $channel
 * @property array $chuanglan
 * @property array $aliyun
 * @property array $gptlink
 */
class SmsConfigDto extends Dto implements ConfigDtoInterface
{
	protected $fillable = [
        'type',
        'channel',
		'chuanglan',
        'aliyun',
        'gptlink',
	];

	/**
	 * 默认数据
	 * @return array
	 */
	public function getDefaultConfig(): array
	{
		return [
			'type'    => $this->getItem('type'),
            'channel' => $this->getItem('channel'),
			'chuanglan'    => $this->getItem('chuanglan', []),
            'aliyun'    => $this->getItem('aliyun', []),
            'gptlink'    => $this->getItem('gptlink', []),
		];
	}

	/**
	 * 更新或创建时的数据.
	 */
	public function getConfigFillable(): array
	{
		return [
			'config' => [
                'channel' => $this->getItem('channel'),
                'chuanglan'    => $this->getItem('chuanglan', []),
                'aliyun'    => $this->getItem('aliyun', []),
                'gptlink'    => $this->getItem('gptlink', []),
			]
		];
	}

	/**
	 * 唯一标识数据.
	 */
	public function getUniqueFillable(): array
	{
		return [
			'type' => $this->getItem('type', Config::SMS),
		];
	}
}
