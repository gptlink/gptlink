<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\CdkGroup;
use Cblink\HyperfExt\BaseCollection;

class CdkGroupCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (CdkGroup $model) {
            $item = [
                'id' => $model->id,
                'name' => $model->name,
                'num' => $model->num,
                'package_id' => $model->package_id,
                'status' => $model->status,
                'created_at' => $model->created_at->toDateTimeString(),
            ];

            if($model->relationLoaded('package')){
                $item['package'] = [
                    'id' => $model->package->id,
                    'name' => $model->package->name,
                    'num' => $model->package->num,
                    'price' => $model->package->price,
                    'expired_day' => $model->package->expired_day,
                ];
            }

            return $item;
        })->toArray();
    }
}
