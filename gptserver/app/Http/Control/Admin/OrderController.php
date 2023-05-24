<?php

namespace App\Http\Control\Admin;

use App\Http\Resource\Admin\OrderCollection;
use App\Model\Order;
use Cblink\HyperfExt\BaseController;

class OrderController extends BaseController
{
    /**
     * 订单列表
     *
     * @return OrderCollection
     */
    public function index()
    {
        $orders = Order::query()
            ->search([
                'nickname' => ['type' => 'keyword', 'field' => 'nickname', 'relate' => 'member'],
                'mobile' => ['type' => 'keyword', 'field' => 'mobile', 'relate' => 'member'],
                'package_id' => ['type' => 'eq'],
                'created_at' => ['type' => 'date'],
                'status' => ['type' => 'eq'],
                'id' => ['type' => 'in'],
                'platform' => ['type' => 'eq'],
                'business_id' => ['type' => 'eq'],
                'paid_no' => ['type' => 'keyword'],
                'trade_no' => ['type' => 'keyword'],
            ])
            ->whenWith(['member' => ['member:id,nickname,mobile']])
            ->orderByDesc('id')
            ->orderByDesc('created_at')
            ->page();

        return new OrderCollection($orders);
    }
}
