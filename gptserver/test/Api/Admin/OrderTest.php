<?php

namespace HyperfTest\Api\Admin;

use App\Model\Order;
use Carbon\Carbon;
use HyperfTest\Factory\OrderFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class OrderTest extends TestCase
{
    use LoginTrait;

    public function testAdminOrderIndex()
    {
        $this->adminLogin();

        $userId = 1;
        $packageId = 1;
        $order = OrderFactory::createByData(['user_id' => $userId, 'package_id' => $packageId]);

        $response = $this->get('/admin/order', [
				'with_query' => ['member'],
				'id' => null,
            	'nickname' => null,
            	'mobile' => null,
				'package_id' => $packageId,
				'status' => '',
                'platform' => '',
                'business_id' => '',
                'paid_no' => null,
                'trade_no' => null,
				'created_at' => sprintf('%s~%s', Carbon::now()->subDay()->toDateString(), Carbon::now()->addDay()->toDateString()),
        ]);

        $this->assertApiSuccess($response);

        OrderFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '订单列表',
            'category' => '订单相关',
            'params' => [],
            'desc' => '',
            'request' => [
                'with_query' => 'array：数组 member 用户信息',
                'id' => '数组 id搜索',
				'nickname' => '昵称搜索',
				'mobile' => '手机号搜索',
                'package_id' => '套餐 id',
                'created_at' => '下单时间 YYYY-MM-DD~YYYY-MM-DD',
                'status' => BaseDto::mapDesc('支付状态', Order::STATUS),
                'platform' => BaseDto::mapDesc('订单来源平台', Order::PLATFORM),
                'business_id' => '商户/模型筛选',
                'paid_no' => '支付流水',
                'trade_no' => '订单号',
            ],
            'request_except' => ['with_query', 'created_at', 'package_id', 'nickname', 'mobile'],
            'response' => [
                '*.id' => '订单 id',
                '*.package_name' => '套餐名称',
                '*.user' => '用户信息',
                '*.user.nickname' => '昵称',
                '*.user.mobile' => '手机号',
                '*.status' => BaseDto::mapDesc('订单状态', Order::STATUS),
                '*.channel' => BaseDto::mapDesc('支付渠道', Order::CHANNEL),
                '*.pay_type' => BaseDto::mapDesc('付款类型', Order::PAY_TYPE),
                '*.payment' => '实付金额(元)',
                '*.trade_no' => '编号',
                '*.paid_no' => '支付流水',
                '*.platform' => BaseDto::mapDesc('订单来源平台', Order::PLATFORM),
                '*.business_id' => 'gptlink商户ID 或 aiyaaa的模型ID',
                '*.created_at' => '创建时间',
            ],
        ]));
    }
}
