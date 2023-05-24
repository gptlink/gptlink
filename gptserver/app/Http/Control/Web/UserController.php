<?php

namespace App\Http\Control\Web;

use App\Http\Resource\MemberPackageRecordCollection;
use App\Http\Resource\MemberResource;
use App\Http\Resource\UserOrderCollection;
use App\Http\Resource\UserPackageCollection;
use App\Http\Resource\UserResource;
use App\Model\ChatGptModel;
use App\Model\ChatGptModelCount;
use App\Model\GptModelCollect;
use App\Model\Member;
use App\Model\MemberPackage;
use App\Model\MemberPackageRecord;
use App\Model\Order;
use Cblink\HyperfExt\BaseController;

class UserController extends BaseController
{
    /**
     * @return MemberResource
     */
    public function profile()
    {
        $member = Member::query()->findOrFail(auth()->id());

        return new MemberResource($member);
    }

    /**
     * 获取用户的资源包
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function billPackage()
    {
        $package = MemberPackage::query()
            ->search([
                'user_id' => ['value' => auth()->id()],
                'channel' => ['type' => 'eq'],
                'type' => ['type' => 'eq'],
                'status' => ['type' => 'in'],
            ])
            ->orderBy('status')
            ->orderByDesc('level')
            ->first();

        return new UserResource($package);
    }

    /**
     * 获取用户的资源包
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function package()
    {
        $package = MemberPackage::query()
            ->search([
                'user_id' => ['value' => auth()->id()],
                'status' => ['type' => 'in'],
                'channel' => ['type' => 'eq'],
                'type' => ['type' => 'eq'],
            ])
            ->orderBy('status')
            ->get();

        return new UserPackageCollection($package);
    }

    /**
     * 用户订单
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function order()
    {
        $orders = Order::query()->where(['user_id' => auth()->id()])
            ->orderByDesc('id')
            ->page();

        return new UserOrderCollection($orders);
    }

    /**
     * 获取用户的套餐记录
     *
     * @return MemberPackageRecordCollection
     */
    public function packageRecord()
    {
        $records = MemberPackageRecord::query()
            ->search([
                'user_id' => ['value' => auth()->id()],
                'channel' => ['type' => 'in'],
                'type' => ['type' => 'in'],
            ])
            ->orderByDesc('id')
            ->page();

        return new MemberPackageRecordCollection($records);
    }
}
