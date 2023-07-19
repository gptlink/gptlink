<?php

namespace App\Http\Control\Admin;

use App\Http\Request\Admin\GivePackageRequest;
use App\Http\Request\Admin\MemberOauthRecordRequest;
use App\Http\Request\Admin\MemberOauthUnbindRequest;
use App\Http\Request\Admin\PackageRecordRequest;
use App\Http\Resource\Admin\MemberCollection;
use App\Http\Resource\Admin\MemberOauthCollection;
use App\Http\Resource\Admin\MemberPackageRecordCollection;
use App\Http\Resource\Admin\MemberResource;
use App\Http\Resource\Admin\UserPackageCollection;
use App\Model\Member;
use App\Model\MemberOauth;
use App\Model\MemberPackage;
use App\Model\MemberPackageRecord;
use App\Model\Package;
use Cblink\HyperfExt\BaseController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MemberController extends BaseController
{
    /**
     * 会员列表
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $userList = Member::query()
            ->search([
                'mobile' => ['type' => 'eq'],
                'nickname' => ['type' => 'keyword'],
                'status' => ['type' => 'eq'],
                'platform' => ['type' => 'eq'],
                'business_id' => ['type' => 'in'],
            ])
            ->orderByDesc('id') // 按照id倒序
            ->page();

        return (new MemberCollection($userList))->toResponse();
    }

    /**
     * 封禁/解封
     *
     * @param $id
     * @return MemberResource
     */
    public function updateStatus($id)
    {
        $member = Member::query()->findOrFail($id);

        $status = $member->status == Member::STATUS_NORMAL ? Member::STATUS_DISABLE : Member::STATUS_NORMAL;

        return new MemberResource($member->updateStatus($status));
    }

    /**
     * 用户套餐列表
     *
     * @param $id
     * @return UserPackageCollection
     */
    public function getPackage($id)
    {
        $memberPackages = MemberPackage::query()->where([
            'user_id' => $id,
            'status' => MemberPackage::STATUS_AVAILABLE,
        ])->get();

        return new UserPackageCollection($memberPackages);
    }

    /**
     * 后台赠送
     *
     * @param $id
     * @param GivePackageRequest $request
     * @return ResponseInterface
     */
    public function givePackage($id, GivePackageRequest $request)
    {
        $package = Package::query()->findOrFail($request->input('package_id'));
        $package->sendToUser($id, MemberPackage::CHANNEL_ADMIN);
        return $this->success();
    }

    /**
     * 套餐记录
     *
     * @return ResponseInterface
     */
    public function packageRecord(PackageRecordRequest $request)
    {
        $records = MemberPackageRecord::query()
            ->search([
                'nickname' => ['type' => 'keyword', 'field' => 'nickname', 'relate' => 'member'],
                'mobile' => ['type' => 'keyword', 'field' => 'mobile', 'relate' => 'member'],
                'channel' => ['type' => 'in'],
                'type' => ['type' => 'in'],
                'user_id' => ['type' => 'eq'],
            ])
            ->whenWith([
                'member' => ['member:id,nickname,mobile'],
            ])
            ->orderByDesc('id')
            ->page();

        return new MemberPackageRecordCollection($records);
    }

    /**
     * 微信授权记录
     *
     * @param MemberOauthRecordRequest $request
     * @return MemberOauthCollection
     */
    public function wechatOauthRecord(MemberOauthRecordRequest $request)
    {
        $oauth = MemberOauth::query()->search([
            'user_id' => ['type' => 'eq', 'field' => 'member_id'],
        ])->get();
        return new MemberOauthCollection($oauth);
    }

    /**
     * 解绑
     *
     * @param MemberOauthUnbindRequest $request
     * @return ResponseInterface
     */
    public function unbindWechatOauth(MemberOauthUnbindRequest $request)
    {
        MemberOauth::query()->where([
            'id' => $request->input('member_oauth_id'),
        ])->update(['member_id' => 0]);

        return $this->success();
    }
}
