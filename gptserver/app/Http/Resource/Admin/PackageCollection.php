<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\Package;
use Cblink\HyperfExt\BaseCollection;
use Hyperf\Utils\Arr;

class PackageCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (Package $model) {
            return [
                'id' => $model->id,
                'name' => $model->name,
                'show_name' => $model->show_name,
                'identity' => $model->identity,
                'code' => $model->code,
                'type' => $model->type,
                'expired_day' => $model->expired_day,
                'num' => $model->num,
                'price' => $model->price,
                'show' => $model->show,
                'level' => $model->level,
                'sort' => $model->sort,
                'order_count' => Arr::get($model, 'order_count'),
                'order_sum_payment' => Arr::get($model, 'order_sum_payment'),
            ];
        })->toArray();
    }
}
