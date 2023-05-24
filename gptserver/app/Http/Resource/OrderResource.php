<?php

namespace App\Http\Resource;

use App\Model\Order;
use Cblink\HyperfExt\BaseResource;

/**
 * @property Order $resource
 */
class OrderResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'trade_no' => $this->resource->trade_no,
            'channel' => $this->resource->channel,
            'pay_type' => $this->resource->pay_type,
            'price' => $this->resource->price,
            'status' => $this->resource->status,
            'package_id' => $this->resource->package_id,
            'package_name' => $this->resource->package_name,
            'platform' => $this->resource->platform,
            'business_id' => $this->resource->business_id,
            'created_at' => $this->resource->created_at->toDateTimeString(),
        ];
    }
}
