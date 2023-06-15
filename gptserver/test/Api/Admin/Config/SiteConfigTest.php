<?php

namespace Api\Admin\Config;

use App\Http\Dto\Config\WebsiteConfigDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class SiteConfigTest extends TestCase
{
    use LoginTrait;

    public function testAdminSiteConfigShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new WebsiteConfigDto([]));

        $response = $this->get(sprintf('/admin/config/%s',  Config::GPT_SECRET_KEY));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取站点配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'icp' => '备案号',
                'name' => '站点名称',
                'key_type' => 'gpt密钥类型',
                'secret_key' => 'gpt密钥',
                'web_logo' => '站点logo',
                'user_logo' => '用户默认头像',
                'admin_logo' => '管理端logo',
                'login_type' => BaseDto::mapDesc('登录方式', WebsiteConfigDto::LOGIN_TYPE),
            ],
        ]));
    }

    /**
     * admin
     *
     * @return void
     * @throws \Throwable
     */
    public function testPostAdminSiteConfig()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::GPT_SECRET_KEY), [
            'config' => [
                'icp' => '备案号',
                'name' => '站点名称',
                'key_type' => 'gpt密钥类型',
                'secret_key' => 'gpt密钥',
                'web_logo' => '站点logo',
                'user_logo' => '用户默认头像',
                'admin_logo' => '管理端logo',
                'login_type' => BaseDto::mapDesc('登录方式', WebsiteConfigDto::LOGIN_TYPE),
            ],
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存站点配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [
                'config' => '配置项',
                'config.icp' => '备案号',
                'config.name' => '站点名称',
                'config.secret_key' => 'gpt密钥',
                'config.key_type' => 'gpt密钥类型',
                'config.web_logo' => '站点logo',
                'config.user_logo' => '用户默认头像',
                'config.admin_logo' => '管理端logo',
                'config.login_type' => BaseDto::mapDesc('登录方式', WebsiteConfigDto::LOGIN_TYPE),
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

}
