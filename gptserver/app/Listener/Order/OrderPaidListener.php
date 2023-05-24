<?php

namespace App\Listener\Order;

use App\Event\OrderPaidEvent;
use App\Model\Package;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * 用户支付完成监听，给用户发放套餐包
 */
class OrderPaidListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            OrderPaidEvent::class,
        ];
    }

    /**
     * @param OrderPaidEvent $event
     * @return void
     */
    public function process(object $event)
    {
        $order = $event->order;

        // 赠送套餐
        $package = Package::query()->findOrFail($order->package_id);
        $package->sendToUser($order->user_id);
    }
}
