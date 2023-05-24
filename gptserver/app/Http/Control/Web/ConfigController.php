<?php

namespace App\Http\Control\Web;

use App\Model\Config;
use Cblink\HyperfExt\BaseController;
use Hyperf\Utils\Arr;

class ConfigController extends BaseController
{
	/**
	 * 配置项获取
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function getBasicInfo()
	{
		$config = Config::query()->where([
			'type' => Config::GPT_SECRET_KEY,
		])->value('config');
		return $this->success($config ? Arr::only($config, ['icp', 'web_logo', 'admin_logo']) : []);
	}
}
