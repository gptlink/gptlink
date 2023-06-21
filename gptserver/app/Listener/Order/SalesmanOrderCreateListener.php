<?php

namespace App\Listener\Order;

use App\Event\SalesmanOrderCreateEvent;
use App\Model\Member;
use App\Model\SalesmanOrder;
use Hyperf\DbConnection\Db;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * 佣金结算
 */
class SalesmanOrderCreateListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            SalesmanOrderCreateEvent::class,
        ];
    }

    /**
     * @param SalesmanOrderCreateEvent $event
     * @return void
     */
    public function process(object $event)
    {
        $event->order->price;

        Db::beginTransaction();

        Member::query()
            ->where('id', $event->order->user_id)
            ->increment('balance', $event->order->price);

        $event->order->update(['status' => SalesmanOrder::STATUS_COMPLETE]);

        Db::commit();
    }
}
