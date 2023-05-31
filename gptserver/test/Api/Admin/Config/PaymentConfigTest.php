<?php

namespace Api\Admin\Config;

use App\Http\Dto\Config\PaymentDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class PaymentConfigTest extends TestCase
{

    use LoginTrait;

    public function testAdminPaymentShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new PaymentDto([]));

        $response = $this->get(sprintf('/admin/config/%s',  Config::PAYMENT));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取支付配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'channel' => BaseDto::mapDesc('开启的支付渠道', PaymentDto::TYPES),
                'official' => '现下支付内容',
            ],
        ]));
    }

    /**
     * admin
     *
     * @return void
     * @throws \Throwable
     */
    public function testPostAdminPayment()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::PAYMENT), [
            'config' => [
                'channel' => PaymentDto::TYPE_OFFICIAL,
                'official' => '线下支付内容',
            ],
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存支付配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [
                'config.channel' => BaseDto::mapDesc('开启的支付渠道', PaymentDto::TYPES),
                'config.official' => '现下支付内容',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }
}
