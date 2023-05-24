<?php

namespace App\Model\Repository;

use App\Http\Dto\MemberPackageDto;
use App\Model\MemberPackageRecord;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;

trait MemberPackageRecordTrait
{
    /**
     * 创建套餐获取记录
     *
     * @param mixed $userId
     * @param $packageId
     * @param MemberPackageDto $dto
     * @return Builder|Model
     */
    public static function createByPackageDto($userId, $packageId, MemberPackageDto $dto)
    {
        return MemberPackageRecord::query()
            ->create($dto->toRecordData($userId, $packageId));
    }
}
