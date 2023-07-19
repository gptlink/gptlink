<?php

namespace App\Http\Control\Salesman;

use App\Model\Member;
use App\Model\SalesmanOrder;
use Cblink\HyperfExt\BaseController;

class SalesmanController extends BaseController
{
    /**
     * 获取余额
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function balance()
    {
        return $this->success([
            'balance' => auth()->user()->balance,
        ]);
    }

    /**
     * 统计
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function statistics()
    {
        return $this->success([
            'order_num' => SalesmanOrder::query()->where('user_id', auth()->id())->count(),
            'order_price' => SalesmanOrder::query()->where('user_id', auth()->id())->sum('price'),
            'custom_num' => Member::query()->where('parent_openid', auth()->user()->openid)->count(),
        ]);
    }
}
