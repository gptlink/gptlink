<?php

namespace App\Http\Resource\Admin;

use Cblink\HyperfExt\BaseResource;

/**
 * @property $resource
 */
class CdkGroupResource extends BaseResource
{
    public function toArray(): array
    {
        $data = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'num' => $this->resource->num,
            'package_id' => $this->resource->package_id,
            'remark' => $this->resource->remark,
            'created_at' => $this->resource->created_at->toDateTimeString(),
        ];

        if ($this->resource->relationLoaded('package') && $this->resource->package) {
            $data['package'] = [
                'id' => $this->resource->package->id,
                'name' => $this->resource->package->name,
                'num' => $this->resource->package->num,
                'price' => $this->resource->package->price,
                'expired_day' => $this->resource->package->expired_day,
            ];
        }

        return $data;
    }
}
