<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\Cdk;
use Carbon\Carbon;
use Cblink\HyperfExt\BaseCollection;

class CdkListCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (Cdk $model) {
            $item = [
                'id' => $model->id,
                'code' => $model->code,
                'package_id' => $model->package_id,
                'user_id' => $model->user_id,
                'group_id' => $model->group_id,
                'status' => $model->status,
                'created_at' => $this->format($model),
                'updated_at' => $this->format($model->updated_at, $model->status == Cdk::STATUS_USED),
            ];

            if ($model->relationLoaded('package')) {
                $item['package'] = [
                    'id' => $model->package->id,
                    'name' => $model->package->name,
                    'num' => $model->package->num,
                    'price' => $model->package->price,
                    'expired_day' => $model->package->expired_day,
                ];
            }

            if ($model->relationLoaded('member')) {
                $item['member'] = $model->member ? [
                    'nickname' => $model->member->nickname,
                    'mobile' => $model->member->mobile,
                ] : null;
            }

            if ($model->relationLoaded('group')) {
                $item['group'] = $model->group ? [
                    'id' => $model->group->id,
                    'name' => $model->group->name,
                ] : null;
            }

            return $item;
        })->toArray();
    }

    /**
     * @param $date
     * @param $show
     * @return string
     */
    public function format($date, $show = true)
    {
        if (! $show) {
            return '';
        }

        if ($date instanceof Carbon) {
            return $date->toDateTimeString();
        }

        return $date;
    }
}
