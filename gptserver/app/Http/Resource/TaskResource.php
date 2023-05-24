<?php

namespace App\Http\Resource;

use App\Model\Task;
use Cblink\HyperfExt\BaseResource;
use Hyperf\Utils\Arr;

/**
 * @property $resource
 */
class TaskResource extends BaseResource
{
    public function toArray(): array
    {
        // 'type', 'title', 'desc', 'platform', 'share_image', 'status', 'rule', 'package_id'
        return [
            'id' => $this->id,
            'type' => $this->type,
            'package_name' => Arr::get($this->package, 'name'),
            'expired_day' => Arr::get($this->package, 'expired_day'),
            'num' => Arr::get($this->package, 'num'),
            'record_count' => $this->record_count
        ];
    }

}
