<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\Dto\Dto;

class WebsiteConfigDto extends Dto implements ConfigDtoInterface
{

	protected $fillable = [
		'type', 'name', 'icp', 'web_logo', 'admin_logo', 'user_logo',
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
            'icp'   => $this->getItem('icp'),
            'web_logo'   => $this->getItem('web_logo'),
            'admin_logo'   => $this->getItem('admin_logo'),
            'user_logo' => $this->getItem('user_logo'),
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
                'icp'   => $this->getItem('icp'),
                'web_logo'   => $this->getItem('web_logo'),
                'admin_logo'   => $this->getItem('admin_logo'),
                'user_logo' => $this->getItem('user_logo'),
			]
		];
	}

	/**
	 * 唯一标识数据.
	 */
	public function getUniqueFillable(): array
	{
		return [
			'type'    => $this->getItem('type', Config::WEBSITE),
		];
	}
}
