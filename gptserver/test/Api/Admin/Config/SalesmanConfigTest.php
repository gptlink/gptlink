<?php

namespace Api\Admin\Config;

use App\Http\Dto\Config\ProtocolDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class SalesmanConfigTest extends TestCase
{
    use LoginTrait;

    public function testAdminSalesmanConfigShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new ProtocolDto([]));

        $response = $this->get(sprintf('/admin/config/%s',  Config::SALESMAN));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取分销配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'enable' => '是否开启分销',
                'open' => '自购是否分佣',
                'rules' => '规则说明',
                'ratio' => '佣金比例',
            ],
        ]));
    }

    public function testPostAdminSalesmanConfig()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::SALESMAN), [
            'config' => [
                'enable' => true,
                'purchase' => true,
                'open' => true,
                'rules' => '规则说明',
                'ratio' => 20,
            ],
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存分销配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [
                'config.enable' => '是否开启分销',
                'config.open' => '开放申请',
                'config.rules' => '规则说明',
                'config.ratio' => '佣金比例',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }
}
