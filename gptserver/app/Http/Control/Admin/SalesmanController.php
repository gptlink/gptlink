<?php

namespace App\Http\Control\Admin;

use App\Http\Resource\Admin\SalesmanOrderCollection;
use App\Http\Resource\Admin\SalesmanResource;
use App\Http\Resource\Admin\SalesmanUserCollection;
use App\Model\Member;
use App\Model\SalesmanOrder;
use Cblink\HyperfExt\BaseController;

class SalesmanController extends BaseController
{
    /**
     * 分消员列表
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $members = Member::query()
            ->search([
                'identity' => ['value' => Member::IDENTITY_SALESMAN],
                'mobile' => ['type' => 'keyword', 'before' => '%'],
                'nickname' => ['type' => 'keyword', 'before' => '%'],
            ])
            ->orderByDesc('balance')
            ->page();

        return new SalesmanUserCollection($members);
    }

    /**
     * 分销员详情
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show($id)
    {
        $member = Member::query()
            ->where('identity', Member::IDENTITY_SALESMAN)
            ->findOrFail($id);

        return new SalesmanResource($member);
    }

    /**
     * 分销订单
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function order()
    {
        $orders = SalesmanOrder::query()
            ->with(['order:id,trade_no,price', 'user:id,nickname,mobile', 'custom:id,nickname,mobile'])
            ->search([
                'status' => ['type' => 'in'],
                'created_at' => ['type' => 'date'],
            ])
            ->latest()
            ->page();

        return new SalesmanOrderCollection($orders);
    }
}
