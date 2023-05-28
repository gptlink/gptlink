<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\Order;
use Cblink\HyperfExt\BaseCollection;

class OrderCollection extends BaseCollection
{
    public function toArray(): array
    {
		return $this->resource->map(function (Order $order) {
			$item = [
				'id' => $order->id,
				'user_id' => $order->user_id,
				'package_name' => $order->package_name,
                'price' => $order->price,
				'payment' => $order->payment,
				'trade_no' => $order->trade_no,
				'status' => $order->status,
				'channel' => $order->channel,
				'pay_type' => $order->pay_type,
				'package_id' => $order->package_id,
                'platform' => $order->platform,
                'business_id' => $order->business_id,
				'created_at' => $order->created_at->toDateTimeString(),
                'paid_no' => $order->paid_no,
			];

			if($order->relationLoaded('member') && $order->member){
				$item['user'] = [
					'nickname'=> $order->member->nickname,
					'mobile'=> $order->member->mobile,
				];
			}

			return $item;
		})->toArray();

//        return app()->get(IDaasService::class)->joinUsersData($this->format());
    }

    public function format(): array
    {
        return $this->resource->map(function (Order $order) {
            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'package_name' => $order->package_name,
                'payment' => $order->payment,
                'trade_no' => $order->trade_no,
                'status' => $order->status,
                'channel' => $order->channel,
                'pay_type' => $order->pay_type,
                'package_id' => $order->package_id,
                'created_at' => $order->created_at->toDateTimeString(),
            ];
        })->toArray();
    }
}
