<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Http\Dto\MemberDto;
use App\Http\Dto\OauthDto;
use App\Model\ChatLog;
use App\Model\Member;
use App\Model\MemberOauth;
use App\Model\MemberPackage;
use App\Model\MemberPackageRecord;
use App\Model\Order;
use App\Model\TaskRecord;

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
        $oauth = MemberOauth::findOrcreateByDto(new OauthDto([
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
        Member::query()->truncate();
        Order::query()->truncate();
        ChatLog::query()->truncate();
        TaskRecord::query()->truncate();
    }
}
