<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Model\MemberPackage;
use App\Model\Order;
use App\Model\Package;
use Carbon\Carbon;

class MemberPackageFactory
{
    public static function createByData(array $payload = [])
    {
        return MemberPackage::query()->create(array_merge([
            'user_id' => 1,
            'name' => '测试套餐',
            'status' => MemberPackage::STATUS_AVAILABLE,
            'channel' => MemberPackage::CHANNEL_ORDER,
            'type' => Package::TYPE_CHAT,
            'num' => -1,
            'used' => 10,
            'price' => '100.01',
            'level' => 1,
            'expired_at' => '2022-12-12'
        ], $payload));
    }

    public static function deleteById($userId)
    {
        return MemberPackage::query()->where('user_id', $userId)->delete();
    }
}
