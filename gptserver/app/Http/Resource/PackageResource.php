<?php

namespace App\Http\Resource;

use Cblink\HyperfExt\BaseResource;

/**
 * @property $resource
 */
class PackageResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'expired_day' => $this->resource->expired_day,
            'num' => $this->resource->num,
            'price' => $this->resource->price,
        ];
    }

}
