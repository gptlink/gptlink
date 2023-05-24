<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

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
            ];
        })->toArray();
    }
}
