<?php

namespace HyperfTest\Api\Admin;

use App\Model\Config;
use Cblink\Dto\Dto;
use Hyperf\Utils\Arr;
use HyperfTest\Factory\ConfigFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class ConfigTest extends TestCase
{
    use LoginTrait;

	public function testAdminConfigShow()
	{
		$this->AdminLogin();
		$config = ConfigFactory::createWechatPaymentData();

		$response = $this->get(sprintf('/admin/config/%s',$config->id));
		$this->assertApiSuccess($response);

		ConfigFactory::deleteById(Arr::get($response->response(),'data.id'));

		$response->build(new BaseDto([
			'project' => ['admin'],
			'name' => '配置项详情',
			'category' => '配置项',
			'params' => [
				3 => '配置项类型 1 公众号配置 2 支付配置 3 分销员规则设置'
			],
			'desc' => '',
			'request' => [],
			'request_except' => [],
			'response' => [],
		]));
	}

    public function testAdminConfigPaymentStore()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s',2), [
			'config' => [
				'mch_id'   => '2218229999',
				'key' => 'J229XXXX80y3fqhf80',
                'app_id' => '公众号 id'
			],
        ]);

        $this->assertApiSuccess($response);

		ConfigFactory::deleteById(Arr::get($response->response(),'data.id'));

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '支付配置项保存',
            'category' => '配置项',
            'params' => [],
            'desc' => '路径参数为 2 支付配置',
            'request' => [
				'config' => '微信支付字段配置',
				'config.mch_id' => 'mch_id 商户号',
				'config.key' => 'key 支付秘钥',
                'config.appid' => '公众号 id',
            ],
            'request_except' => [],
            'response' => [
				'type' => '类型',
				'id' => '数据id',
                'config.mch_id' => '商户id',
                'config.key' => '支付秘钥key',
                'config.appid' => '公众号 id',
			],
        ]));
    }

	public function testAdminConfigWechatPlatformStore()
	{
		$this->AdminLogin();

		$response = $this->post(sprintf('/admin/config/%s',1), [
			'config' => [
				'appid'   => 'xxxxxx',
				'sercert' => 'x2c324323432',
			],
		]);

		$this->assertApiSuccess($response);

		ConfigFactory::deleteById(Arr::get($response->response(),'data.id'));

		$response->build(new BaseDto([
			'project' => ['admin'],
			'name' => '公众号配置项保存',
			'category' => '配置项',
			'params' => [],
			'desc' => '路径参数为 1 公众号配置',
			'request' => [
				'config' => 'array：公众号配置',
				'config.appid' => '公众号appid',
				'config.sercert' => '公众号sercert',
			],
			'request_except' => [],
			'response' => [
				'type' => '类型',
				'config.appid' => '商户id',
				'type.sercert' => '支付秘钥key',
				'id' => '数据id',
			],
		]));
	}

    /**
     * 短信创蓝配置
     *
     * @return void
     * @throws \Throwable
     */
    public function testAdminConfigChuangLanStore()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::SMS_CHUANG_LAN), [
            'config' => [
                'account'   => 'N123456',
                'password' => '1234562',
                'sign' => 'test'
            ],
        ]);

        $this->assertApiSuccess($response);

        ConfigFactory::deleteById(Arr::get($response->response(),'data.id'));

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '短信创蓝配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '路径参数为 4 短信创蓝配置',
            'request' => [
                'config' => 'array：创蓝配置',
                'config.account' => '账号',
                'config.password' => '密码',
                'config.sign' => '签名',
            ],
            'request_except' => [],
            'response' => [
                'type' => '类型',
                'id' => '数据id',
                'config' => '配置内容',
                'config.account' => '账号内容',
                'config.password' => '密码',
                'config.sign' => '签名'
            ],
        ]));
    }

    /**
     * 微信 pc 端
     *
     * @return void
     * @throws \Throwable
     */
    public function testAdminConfigWechatWebStore()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::WECHAT_WEB), [
            'config' => [
                'client_id'   => 'N123456',
                'client_secret' => '1234562',
            ],
        ]);

        $this->assertApiSuccess($response);

        ConfigFactory::deleteById(Arr::get($response->response(),'data.id'));

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '微信WEB应用配置',
            'category' => '配置项',
            'params' => [],
            'desc' => 'pc应用配置',
            'request' => [
                'config' => 'array：wechat web 配置',
                'config.client_id' => '应用 id',
                'config.client_secret' => '应用密钥',
            ],
            'request_except' => [],
            'response' => [
                'id' => '数据id',
                'type' => \Cblink\Hyperf\Yapi\Dto::mapDesc('type类型配置项: ', Config::TYPE),
                'config' => '配置内容',
                'config.client_ID' => '应用 id',
                'config.client_secret' => '应用密钥',
            ],
        ]));
    }

    /**
     * admin
     *
     * @return void
     * @throws \Throwable
     */
    public function testAdminConfigGptSecretKey()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::GPT_SECRET_KEY), [
            'config' => [
                'secret_key'   => 'api123456789',
                'icp' => 'icp备案号',
                'web_logo' => 'base64',
                'admin_logo' => 'base64'
            ],
        ]);

        $this->assertApiSuccess($response);

        ConfigFactory::deleteById(Arr::get($response->response(),'data.id'));

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => 'api接口密钥',
            'category' => '配置项',
            'params' => [],
            'desc' => 'pc应用配置',
            'request' => [
                'config' => 'array：wechat web 配置',
                'config.secret_key' => 'api 密钥',
                'config.icp' => 'icp备案号',
                'config.web_logo' => '图片base64',
                'config.admin_logo' => '图片base64'
            ],
            'request_except' => [],
            'response' => [
                'id' => '数据id',
                'type' => \Cblink\Hyperf\Yapi\Dto::mapDesc('type类型配置项: ', Config::TYPE),
                'config' => '配置内容',
                'config.secret_key' => 'api密钥',
                'config.icp' => 'icp备案号',
                'config.web_logo' => '图片base64',
                'config.admin_logo' => '图片base64'
            ],
        ]));
    }
}
