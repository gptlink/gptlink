<?php

namespace App\Http\Resource\Salesman;

use App\Model\Member;
use Cblink\HyperfExt\BaseCollection;

class CustomCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (Member $member) {
            return [
                'openid' => $member->code,
                'nickname' => $member->nickname,
                'avatar' => $member->avatar,
                'order_price' => $member->order_price,
                'order_num' => $member->order_num,
                'created_at' => $member->created_at->toDatetimeString(),
            ];
        })->toArray();
    }
}
