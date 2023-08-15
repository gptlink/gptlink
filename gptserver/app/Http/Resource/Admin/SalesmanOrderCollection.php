<?php

namespace App\Http\Resource\Admin;

use App\Model\SalesmanOrder;
use Cblink\HyperfExt\BaseCollection;

class SalesmanOrderCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (SalesmanOrder $order) {
            return [
                'id' => $order->id,
                'trade_no' => $order->order->trade_no,
                'type' => $order->type,
                'order_id' => $order->order_id,
                'ratio' => $order->ratio,
                'order_price' => $order->order->price,
                'price' => $order->price,
                'status' => $order->status,
                'user' => [
                    'id' => $order->user->id,
                    'nickname' => $order->user->nickname,
                    'mobile' => $order->user->mobile,
                ],
                'custom' => [
                    'id' => $order->custom->id,
                    'nickname' => $order->custom->nickname,
                    'mobile' => $order->custom->mobile,
                ],
            ];
        })->toArray();
    }
}
