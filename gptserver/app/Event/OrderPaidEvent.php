<?php

namespace App\Event;

use App\Model\Order;

class OrderPaidEvent
{
    /**
     * @var Order
     */
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
