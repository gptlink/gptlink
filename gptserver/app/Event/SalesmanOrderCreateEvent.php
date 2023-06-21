<?php

namespace App\Event;

use App\Model\SalesmanOrder;

class SalesmanOrderCreateEvent
{
    /**
     * @var SalesmanOrder
     */
    public $order;

    public function __construct(SalesmanOrder $order)
    {
        $this->order = $order;
    }
}
