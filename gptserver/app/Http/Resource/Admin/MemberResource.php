<?php

namespace App\Http\Resource\Admin;

use App\Model\Member;
use Cblink\HyperfExt\BaseResource;

/**
 * @property Member $resource
 */
class MemberResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'nickname' => $this->resource->nickname,
            'mobile' => $this->resource->mobile,
            'avatar' => $this->resource->avatar,
            'status' => $this->resource->status,
            'register_at' => $this->resource->created_at->toDateTimeString(),
        ];
    }
}
