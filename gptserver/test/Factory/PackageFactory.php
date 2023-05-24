<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Model\MemberPackage;
use App\Model\MemberPackageRecord;
use App\Model\Order;
use App\Model\Package;
use Carbon\Carbon;

class PackageFactory
{
    public static function createByData(array $payload = [])
    {
        return Package::query()->create(array_merge([
            'id' => 1,
            'name' => '套餐名称',
            'type' => Package::TYPE_CHAT,
            'sort' => 10,
            'expired_day' => 15,
            'num' => -1,
            'price' => '100.01',
            'level' => 1,
            'show' => Package::SHOW_ON,
            'show_name' => '测试套餐',
            'identity' => Package::IDENTITY_USER
        ], $payload));
    }

    public static function truncate()
    {
        Package::query()->truncate();
        MemberPackage::query()->truncate();
        MemberPackageRecord::query()->truncate();
    }

    public static function deleteById($id)
    {
        Package::query()->where('id', $id)->delete();
    }
}
