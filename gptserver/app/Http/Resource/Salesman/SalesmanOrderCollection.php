<?php

namespace App\Http\Resource\Salesman;

use App\Model\SalesmanOrder;
use Cblink\HyperfExt\BaseCollection;

class SalesmanOrderCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (SalesmanOrder $order) {
            $item = [
                'id' => $order->id,
                'type' => $order->type,
                'ratio' => $order->ratio,
                'price' => $order->price,
                'user_id' => $order->user_id,
                'status' => $order->status,
                'custom_id' => $order->custom_id,
                'created_at' => $order->created_at->toDatetimeString(),
            ];

            if ($order->relationLoaded('custom')) {
                $item['custom'] = [
                    'openid' => $order->custom->code,
                    'nickname' => $this->desensitization($order->custom->nickname),
                ];
            }

            return $item;
        })->toArray();
    }

    /**
     * @param $str
     * @param int $num
     * @return string
     */
    public function desensitization($str, int $num = 2)
    {
        $len = mb_strlen($str);

        if ($len <= $num) {
            return $str;
        }

        return mb_substr($str, 0, 2) . str_pad('', $len - $num, '*');
    }
}
