<?php

namespace App\Model\Repository;

use App\Event\OrderCreateEvent;
use App\Event\OrderPaidEvent;
use App\Http\Dto\OrderDto;
use App\Model\Order;

trait OrderTrait
{
    /**
     * 创建订单
     *
     * @param OrderDto $orderDto
     * @return Order
     */
    public static function createByDto(OrderDto $orderDto)
    {
        $order = Order::query()->create($orderDto->toData());

        event(new OrderCreateEvent($order));

        return $order;
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->status == Order::STATUS_PAID;
    }

    /**
     * 付款金额
     *
     * @param $payment
     * @param null $paidNo
     * @return void
     */
    public function paid($payment, $paidNo = null)
    {
        $this->payment = $payment;
        $this->paid_no = $paidNo;
        $this->status = Order::STATUS_PAID;
        $this->save();

        event(new OrderPaidEvent($this));
    }

}
