<?php

declare(strict_types=1);

namespace App\Http\Resource;

use App\Model\Task;
use Cblink\HyperfExt\BaseCollection;

class TaskCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (Task $task) {
            return [
                'id' => $task->id,
                'type' => $task->type,
                'title' => $task->title,
                'status' => $task->status,
                'desc' => $task->desc,
                'platform' => explode(',', $task->platform),
                'share_image' => $task->share_image,
                'rule' => $task->rule,
                'package_id' => $task->package_id,
                'package' => $task->package,
                'is_completed' => $this->checkTask($task),
            ];
        })->toArray();
    }

    public function checkTask(Task $task)
    {
        return $task->checkCompleted($task->type, auth()->id());
    }
}
