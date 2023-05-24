<?php

declare(strict_types=1);

namespace App\Http\Resource;

use App\Model\Order;
use Cblink\HyperfExt\BaseCollection;

class UserOrderCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (Order $order) {
            return [
                'id' => $order->id,
                'trade_no' => $order->trade_no,
                'user_id' => $order->user_id,
                'channel' => $order->channel,
                'pay_type' => $order->pay_type,
                'price' => $order->price,
                'payment' => $order->payment,
                'status' => $order->status,
                'package_id' => $order->package_id,
                'package_name' => $order->package_name,
                'created_at' => $order->created_at->toDateTimeString(),
            ];
        })->toArray();
    }
}
