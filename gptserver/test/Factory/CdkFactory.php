<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Http\Dto\CdkGroupDto;
use App\Model\Cdk;
use App\Model\CdkGroup;

class CdkFactory
{
    /**
     * @param array $payload
     * @return CdkGroup|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createGroupByData(array $payload = [])
    {
        return CdkGroup::createByDto(new CdkGroupDto(array_merge([
            'name' => '娜姐姐有彩旗',
            'package_id' => 16,
            'num' => '10',
            'price' => 1000,
            'remark' => '这个是备注信息',
        ], $payload)));
    }

    public static function deleteById($id)
    {
        CdkGroup::query()->where('id', $id)->delete();
        Cdk::query()->where('group_id', $id)->delete();
    }

    public static function truncate()
    {
        CdkGroup::query()->truncate();
        Cdk::query()->truncate();
    }

    public static function createCdksByGroup($num, $packageId, $groupId)
    {
        for ($i = 0; $i < $num; $i++) {
            $cdk = Cdk::generate($packageId, $groupId);
        }

        return $cdk;
    }
}
