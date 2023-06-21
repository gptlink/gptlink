<?php

namespace App\Http\Dto;

use App\Model\SalesmanOrder;
use Cblink\HyperfExt\Dto;

class SalesmanOrderDto extends Dto
{
    protected $fillable = [
        'order_id', 'ratio', 'order_price', 'user_id', 'status', 'custom_id',
    ];

    public function toModel()
    {
        $price = bcmul((string) $this->getItem('order_price'), bcdiv((string) abs($this->getItem('ratio')), '100', 2), 2);

        return [
            'type' => SalesmanOrder::TYPE_SALESMAN,
            'order_id' => $this->getItem('order_id'),
            'ratio' => $this->getItem('ratio'),
            'order_price' => $this->getItem('order_price'),
            'price' => $price,
            'user_id' => $this->getItem('user_id'),
            'custom_id' => $this->getItem('custom_id'),
            'status' => $this->getItem('status', SalesmanOrder::STATUS_PADDING),
        ];
    }
}
