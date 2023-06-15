<?php

namespace Api\Admin\Config;

use App\Http\Dto\Config\WebsiteConfigDto;
use App\Http\Dto\Config\WechatPaymentDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class WechatPayConfigTest extends TestCase
{
    use LoginTrait;

    public function testAdminWechatPayShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new WechatPaymentDto([]));

        $response = $this->get(sprintf('/admin/config/%s',  Config::WECHAT_PAYMENT));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取微信支付配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'mch_id'   => '微信商户ID',
                'key' => '商户密钥',
                'app_id' => '支付的公众号 id'
            ],
        ]));
    }

    /**
     * admin
     *
     * @return void
     * @throws \Throwable
     */
    public function testPostAdminWechatPayShow()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::WECHAT_PAYMENT), [
            'config' => [
                'mch_id'   => '微信商户ID',
                'key' => '商户密钥',
                'app_id' => '支付的公众号 id'
            ],
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存微信支付配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [
                'config.mch_id'   => '微信商户ID',
                'config.key' => '商户密钥',
                'config.app_id' => '支付的公众号 id'
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

}
