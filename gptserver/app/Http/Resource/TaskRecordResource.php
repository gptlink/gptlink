<?php

namespace App\Http\Resource;

use App\Model\Task;
use Cblink\HyperfExt\BaseResource;
use Hyperf\Utils\Arr;

/**
 * @property $resource
 */
class TaskRecordResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'package_name' => $this->package_name,
            'expired_day' => $this->expired_day,
            'num' => $this->num,
            'is_read' => $this->is_read,
            'created_at' => $this->created_at
        ];
    }

}
