<?php

namespace App\Http\Control\Salesman;

use App\Http\Resource\Salesman\SalesmanOrderCollection;
use App\Model\SalesmanOrder;
use Cblink\HyperfExt\BaseController;

class OrderController extends BaseController
{
    /**
     * 分销订单列表
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $orders = SalesmanOrder::query()
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->with('custom:id,code,nickname')
            ->page();

        return new SalesmanOrderCollection($orders);
    }
}
