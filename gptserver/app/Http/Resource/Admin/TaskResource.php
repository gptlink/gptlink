<?php

namespace App\Http\Resource\Admin;

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
        return [
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'title' => $this->resource->title,
            'desc' => $this->resource->desc,
            'platform' => explode(',', $this->resource->platform),
            'share_image' => $this->resource->share_image,
            'status' => $this->resource->status,
            'rule' => $this->resource->rule,
            'package_id' => $this->resource->package_id,
            'package' => [
                'id' => Arr::get($this->resource->package, 'id'),
                'name' => Arr::get($this->resource->package, 'name')
            ],
        ];
    }

}
