<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Model\Order;

class OrderFactory
{
    public static function createByData(array $payload = [])
    {
        return Order::query()->create(array_merge([
            'trade_no' => 'test',
            'user_id' => 1,
            'channel' => Order::CHANNEL_WECHAT,
            'pay_type' => Order::PAY_JSAPI,
            'paid_no' => 'test',
            'payload' => [
                'prepay_id' => 'test1',
            ],
            'price' => '10.1',
            'payment' => '10.1',
            'status' => Order::STATUS_UNPAID,
            'package_id' => 1,
            'package_name' => 'test',
            'platform' => Order::PLATFORM_GPT,
        ], $payload));
    }

    public static function truncate()
    {
        Order::query()->truncate();
    }
}
