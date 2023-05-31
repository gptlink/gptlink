<?php

namespace Api\Admin\Config;

use App\Http\Dto\Config\GptSecretKeyDto;
use App\Http\Dto\Config\ProtocolDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class ProtocolConfigTest extends TestCase
{
    use LoginTrait;

    public function testAdminProtocolShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new ProtocolDto([]));

        $response = $this->get(sprintf('/admin/config/%s',  Config::PROTOCOL));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取协议配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'title' => '协议名称',
                'agreement' => '协议内容',
            ],
        ]));
    }

    /**
     * admin
     *
     * @return void
     * @throws \Throwable
     */
    public function testPostAdminProtocol()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::PROTOCOL), [
            'config' => [
                'title' => '协议名称',
                'agreement' => '协议内容',
            ],
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存协议配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [
                'config.title' => '协议名称',
                'config.agreement' => '协议内容',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }
}
