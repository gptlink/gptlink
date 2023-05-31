<?php

namespace Api\Admin\Config;

use App\Http\Dto\Config\WechatPlatformDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class WechatOfficialConfigTest extends TestCase
{
    use LoginTrait;

    public function testAdminWechatWebShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new WechatPlatformDto([]));

        $response = $this->get(sprintf('/admin/config/%s',  Config::WECHAT_PLATFORM));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取微信公众号配置',
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

        $response = $this->post(sprintf('/admin/config/%s', Config::WECHAT_PLATFORM), [
            'config' => [
                'client_id'   => 'APPID',
                'client_secret' => '应用Secret',
            ],
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存微信公众号配置',
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
