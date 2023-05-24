<?php

namespace App\Http\Service;

use App\Model\Member;
use App\Model\Order;

/**
 * 统计服务
 */
class StatisicsService
{
    /**
     * 会员统计
     * @return int
     */
    public function userCount()
    {
        return Member::count();
    }

    /**
     * 支付金额统计
     * @return int|mixed|string
     */
    public function paymentCount()
    {
        return Order::query()->where([
            'status' => Order::STATUS_PAID
        ])->sum('payment');
    }
}
