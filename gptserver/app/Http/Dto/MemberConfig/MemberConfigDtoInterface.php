<?php

declare(strict_types=1);

namespace App\Http\Dto\MemberConfig;

interface MemberConfigDtoInterface
{
    /**
     * 获取默认配置.
     */
    public function getDefaultConfig(): array;

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array;

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array;
}
