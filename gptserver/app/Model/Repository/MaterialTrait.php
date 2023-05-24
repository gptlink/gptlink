<?php

namespace App\Model\Repository;

use App\Http\Dto\MaterialDto;
use App\Model\Material;

trait MaterialTrait
{
    /**
     * 创建
     *
     * @param MaterialDto $dto
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createByDto(MaterialDto $dto)
    {
        return Material::query()->create($dto->getCreateData());
    }
}
