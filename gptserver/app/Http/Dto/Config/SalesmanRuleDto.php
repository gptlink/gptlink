<?php

namespace App\Http\Dto\Config;

use Cblink\Dto\Dto;

/**
 * @property string $rule 分销规则
 */
class SalesmanRuleDto extends Dto implements ConfigDtoInterface
{
	protected $fillable = [
		'rule', 'type'
	];

	/**
	 * 默认数据
	 * @return array
	 */
	public function getDefaultConfig(): array
	{
		return [
			'type'    => $this->getItem('type'),
			'rule'    => $this->getItem('rule'),
		];
	}

	/**
	 * 更新或创建时的数据.
	 */
	public function getConfigFillable(): array
	{
		return [
			'config' => [
				'rule' => $this->getItem('rule'),
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
