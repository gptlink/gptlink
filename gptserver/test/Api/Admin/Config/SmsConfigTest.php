<?php

namespace Api\Admin\Config;

use App\Http\Dto\Config\WebsiteConfigDto;
use App\Http\Dto\Config\SmsConfigDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class SmsConfigTest extends TestCase
{
    use LoginTrait;

    public function testAdminSmsShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new SmsConfigDto([]));

        $response = $this->get(sprintf('/admin/config/%s',  Config::SMS));

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
                'account' => '创蓝账号',
                'password' => '创蓝密码',
                'sign' => '签名',
            ],
        ]));
    }

    /**
     * admin
     *
     * @return void
     * @throws \Throwable
     */
    public function testPostAdminSms()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::SMS), [
            'config' => [
                'account' => '创蓝账号',
                'password' => '创蓝密码',
                'sign' => '签名',
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
                'config.account' => '创蓝账号',
                'config.password' => '创蓝密码',
                'config.sign' => '签名',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

}
