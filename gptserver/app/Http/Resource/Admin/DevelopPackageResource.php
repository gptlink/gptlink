<?php

namespace App\Http\Resource\Admin;

use Cblink\HyperfExt\BaseResource;

class DevelopPackageResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'name' => $this->resource['name'],
            'num' => $this->resource['num'],
            'used' => $this->resource['used'],
            'expired_at' => $this->resource['expired_at'],
        ];
    }
}
