<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Http\Dto\MemberDisabledRcordDto;
use App\Http\Dto\MemberDto;
use App\Http\Dto\OauthDto;
use App\Model\ChatLog;
use App\Model\Member;
use App\Model\MemberDisabledRecord;
use App\Model\MemberIdentity;
use App\Model\MemberOauth;
use App\Model\MemberPackage;
use App\Model\MemberPackageRecord;
use App\Model\Order;
use App\Model\TaskRecord;
use App\Model\UserTree;
use Carbon\Carbon;

class MemberFactory
{
    /**
     * @param array $payload
     * @return Member|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createByData(array $payload = [])
    {
        return Member::createByDto(new MemberDto(array_merge([
            'nickname' => 'test',
            'avatar' => 'test.jpg',
            'mobile' => '13100010001',
            'platform',
            'business_id',
            'source',
        ], $payload)));
    }

    /**
     * @param $memberId
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createOauth($memberId)
    {
        $oauth = MemberOauth::createByDto(new OauthDto([
            'nickname' => 'nickname',
            'avatar' => 'avatar',
            'openid' => 'openid',
            'unionid' => 'unionid',
            'platform' => 'weixin',
            'appid' => 'appid',
        ]));
        $oauth->update(['member_id' => $memberId]);
        return $oauth->refresh();
    }

    public static function truncate()
    {
        MemberOauth::query()->truncate();
        MemberPackage::query()->truncate();
        MemberPackageRecord::query()->truncate();
        MemberDisabledRecord::query()->truncate();
        MemberIdentity::query()->truncate();
        UserTree::query()->truncate();
        Member::query()->truncate();
    }

    public static function deleteById($id)
    {
        MemberOauth::query()->where('member_id', $id)->delete();
        MemberPackage::query()->where('user_id', $id)->delete();
        MemberPackageRecord::query()->where('user_id', $id)->delete();
        Order::query()->where('user_id', $id)->delete();
        ChatLog::query()->where('user_id', $id)->delete();
        MemberDisabledRecord::query()->where('member_id', $id)->delete();
        MemberIdentity::query()->where('user_id', $id)->delete();
        UserTree::query()->where('user_id', $id)->orWhere('parent_id', $id)->delete();
        TaskRecord::query()->where('user_id', $id)->delete();
        return  Member::query()->where('id', $id)->delete();
    }

    public static function deleteByMobile($mobile)
    {
        $member = Member::query()->where(['mobile' => $mobile])->firstOrFail();

        return self::deleteById($member->id);
    }

    public static function createDisabledByData(array $payload = [])
    {
        $dto = new MemberDisabledRcordDto(array_merge([
            'member_id' => '1',
            'trigger' => '太涩情了',
            'content' => '太涩情了',
            'lable' => 'Porn',
            'appeal' => '申请解封',
            'mobile' => '13266589988',
            'status' => 1,
            'suggestion' => 'xxxx',
            'score' => 100,
            'apply_at' => Carbon::now()->toDateTimeString(),
            'disabled_at' => Carbon::now()->toDateTimeString(),
        ], $payload));

        return MemberDisabledRecord::createByDto($dto);
    }

    public static function deleteDisabledRecord()
    {
        MemberDisabledRecord::query()->truncate();
    }
}
