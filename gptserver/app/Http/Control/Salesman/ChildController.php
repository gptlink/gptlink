<?php

namespace App\Http\Control\Salesman;

use App\Http\Resource\Salesman\CustomCollection;
use App\Model\Member;
use Cblink\HyperfExt\BaseController;

class ChildController extends BaseController
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $members = Member::query()
            ->where('parent_openid', auth()->user()->code)
            ->withCount(['customSalesmanOrder as order_num'])
            ->withSum(['customSalesmanOrder as order_price'], 'price')
            ->orderByDesc('id')
            ->page(['id', 'nickname', 'avatar', 'code', 'status', 'parent_openid', 'identity']);

        return new CustomCollection($members);
    }
}
