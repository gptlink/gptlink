<?php

declare(strict_types=1);

namespace HyperfTest\TestDto;

use Cblink\Hyperf\Yapi\Dto;

class BaseDto extends Dto
{
    public function getConfig(): array
    {
        return require BASE_PATH . '/test/yapi.php';
    }
}
