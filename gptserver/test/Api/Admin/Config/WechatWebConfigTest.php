<?php

namespace Api\Admin\Config;

use App\Http\Dto\Config\GptSecretKeyDto;
use App\Http\Dto\Config\WechatWebDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class WechatWebConfigTest extends TestCase
{
    use LoginTrait;

    public function testAdminWechatWebShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new WechatWebDto([]));

        $response = $this->get(sprintf('/admin/config/%s',  Config::WECHAT_WEB));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取微信网站应用配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'client_id'   => 'APPID',
                'client_secret' => '应用Secret',
            ],
        ]));
    }

    /**
     * admin
     *
     * @return void
     * @throws \Throwable
     */
    public function testPostAdminWechatWebShow()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::WECHAT_WEB), [
            'config' => [
                'client_id'   => 'APPID',
                'client_secret' => '应用Secret',
            ],
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存微信网站应用配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [
                'config.client_id'   => 'APPID',
                'config.client_secret' => '应用Secret',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

}
