<?php

declare(strict_types = 1);

namespace HyperfTest\Factory;

use App\Http\Dto\Config\GptSecretKeyDto;
use App\Http\Dto\Config\WechatPaymentDto;
use App\Http\Dto\Config\WechatPlatformDto;
use App\Model\Config;

class ConfigFactory
{
	public static function createWechatPlaformData()
	{
		return Config::updateOrCreateByDto(new WechatPlatformDto([
			'type'    => 1,
			'appid'   => 'xxxxxx',
			'sercert' => 'x2c324323432',
		]));
	}

	public static function createWechatPaymentData()
	{
		return Config::updateOrCreateByDto(new WechatPaymentDto([
			'type' => 2,
			'mch_id'   => '1xxxxx',
			'key'      => '2xxxxx',
			'cert'     => '3xxxxx',
			'cert_key' => '4xxxxx',
		]));
	}

	public static function deleteById($id)
	{
		Config::query()->where('id', $id)->delete();
	}

    public static function createGptSecretKeyData()
    {
        return Config::updateOrCreateByDto(new GptSecretKeyDto([
            'type' => Config::GPT_SECRET_KEY,
            'secret_key'   => 'api123456789',
            'icp' => 'icp备案号',
            'web_logo' => 'base64',
            'admin_logo' => 'base64'
        ]));
    }
}
