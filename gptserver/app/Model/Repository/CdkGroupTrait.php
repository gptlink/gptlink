<?php

namespace App\Model\Repository;

use App\Http\Dto\CdkGroupDto;
use App\Job\CreateCdkJob;
use App\Model\CdkGroup;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;

trait CdkGroupTrait
{
    /**
     * 创建CDK和生成cdk
     * @param CdkGroupDto $dto
     * @return Builder|Model
     */
    public static function createByDto(CdkGroupDto $dto)
    {
        $cdkGroup = CdkGroup::query()->create($dto->createData());
        asyncQueue(new CreateCdkJob($cdkGroup));

        return $cdkGroup;
    }

    /**
     * 更新
     * @param CdkGroupDto $dto
     * @return CdkGroup
     */
    public function updateByDto(CdkGroupDto $dto)
    {
        $this->update($dto->updateData());
        return $this->refresh();
    }
}
