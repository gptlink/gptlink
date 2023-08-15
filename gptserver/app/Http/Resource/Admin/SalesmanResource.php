<?php

namespace App\Http\Resource\Admin;

use Cblink\HyperfExt\BaseResource;

class SalesmanResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'nickname' => $this->resource->nickname,
            'avatar' => $this->resource->avatar,
            'mobile' => $this->resource->mobile,
            'status' => $this->resource->status,
            'platform' => $this->resource->platform,
            'source' => $this->resource->source,
            'account_type' => $this->resource->account_type,
            'balance' => $this->resource->balance,
            'ratio' => $this->resource->ratio,
            'created_at' => $this->resource->created_at->toDatetimeString(),
        ];
    }
}
