<?php

namespace App\Http\Resource;

use Cblink\HyperfExt\BaseResource;

/**
 * @property $resource
 */
class UserResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'user_id' => $this->resource->user_id,
            'channel' => $this->resource->channel,
            'type' => $this->resource->type,
            'num' => $this->resource->num,
            'used' => $this->resource->used,
            'expired_at' => $this->resource->expired_at,
            'created_at' => $this->resource->created_at,
        ];
    }
}
