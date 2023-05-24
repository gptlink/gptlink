<?php

namespace App\Event;

use App\Model\Order;

class OrderCreateEvent
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
