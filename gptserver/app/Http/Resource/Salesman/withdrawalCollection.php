<?php

namespace App\Http\Resource\Salesman;

use App\Model\Withdraw;
use Cblink\HyperfExt\BaseCollection;

class withdrawalCollection extends BaseCollection
{

    public function toArray(): array
    {
        return $this->resource->map(function (Withdraw $withdraw) {
            return [
                'id' => $withdraw->id,
                'serial_no' => $withdraw->serial_no,
                'price' => $withdraw->price,
                'status' => $withdraw->status,
                'paid_no' => $withdraw->paid_no,
                'user_id' => $withdraw->user_id,
                'created_at' => $withdraw->created_at->toDatetimeString(),
            ];
        })->toArray();
    }

}
