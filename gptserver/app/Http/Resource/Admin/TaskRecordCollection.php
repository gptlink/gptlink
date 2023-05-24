<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\TaskRecord;
use Cblink\HyperfExt\BaseCollection;

class TaskRecordCollection extends BaseCollection
{
    public function toArray(): array
    {
		return $this->resource->map(function (TaskRecord $taskRecord) {
			$item = [
				'id' => $taskRecord->id,
				'task_id' => $taskRecord->task_id,
				'user_id' => $taskRecord->user_id,
				'type' => $taskRecord->type,
				'package_name' => $taskRecord->package_name,
				'expired_day' => $taskRecord->expired_day,
				'num' => $taskRecord->num,
				'created_at' => $taskRecord->created_at->toDateTimeString()
			];

			if($taskRecord->relationLoaded('member')){
				$item['user'] = [
					'nickname'=> $taskRecord->member->nickname,
					'mobile'=> $taskRecord->member->mobile,
				];
			}

			return $item;
		})->toArray();

//        return app()->get(IDaasService::class)->joinUsersData($this->format());
    }

    public function format(): array
    {
        return $this->resource->map(function (TaskRecord $taskRecord) {
            return [
                'id' => $taskRecord->id,
                'task_id' => $taskRecord->task_id,
                'user_id' => $taskRecord->user_id,
                'type' => $taskRecord->type,
                'package_name' => $taskRecord->package_name,
                'expired_day' => $taskRecord->expired_day,
                'num' => $taskRecord->num,
                'created_at' => $taskRecord->created_at->toDateTimeString(),
            ];
        })->toArray();
    }
}
