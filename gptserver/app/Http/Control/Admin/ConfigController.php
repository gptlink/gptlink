<?php

namespace App\Http\Control\Admin;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Request\Admin\ConfigStoreRequest;
use App\Model\Config;
use Cblink\HyperfExt\BaseController;

class ConfigController extends BaseController
{
	/**
	 * 配置项获取
	 * @param $type
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function show($type)
	{
		$config = Config::query()->where([
			'type' => $type,
		])->first();

		return $this->success($config ? $config->toArray() : []);
	}

	/**
	 * 配置项保存
	 * @param $type integer 配置项类型
	 * @param ConfigStoreRequest $request
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \Throwable
	 */
	public function store($type, ConfigStoreRequest $request)
	{
		// 如果类型不存在 抛异常
		throw_if(! in_array($type, array_keys(Config::TYPE)), LogicException::class, ErrCode::TYPE_IS_INVALID);

		$params = $request->input('config', []);

		// 根据类型获取dto
		$useDto = Config::getTypeByDto($type, array_merge(['type' => $type], $params));
		// 调用保存方法 传入对应dto数据
		$config = Config::updateOrCreateByDto($useDto);

		return $this->success($config->toArray());
	}
}
