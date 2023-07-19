<?php

namespace App\Http\Resource\Admin;

use Cblink\HyperfExt\BaseResource;

/**
 * @property $resource
 */
class PromptResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'icon' => $this->resource->icon,
            'name' => $this->resource->name,
            'prompt' => $this->resource->prompt,
            'system' => $this->resource->system,
            'status' => $this->resource->status,
            'sort' => $this->resource->sort,
            'platform' => $this->resource->platform,
            'desc' => $this->resource->desc,
            'remark' => $this->resource->remark,
            'type' => $this->resource->type,
        ];
    }
}
