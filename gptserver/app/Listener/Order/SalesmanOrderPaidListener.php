<?php

namespace App\Listener\Order;

use App\Event\OrderPaidEvent;
use App\Http\Dto\Config\SalesmanDto;
use App\Http\Dto\SalesmanOrderDto;
use App\Model\Config;
use App\Model\Member;
use App\Model\SalesmanOrder;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * 用户支付完成监听，创建分销订单
 */
class SalesmanOrderPaidListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            OrderPaidEvent::class,
        ];
    }

    /**
     * @param OrderPaidEvent $event
     * @throws \Throwable
     */
    public function process(object $event)
    {
        // 判断是否符合分销条件
        /* @var SalesmanDto $config */
        $config = Config::toDto(Config::SALESMAN);

        if (! $config->enable) {
            return;
        }
        /* @var Member */
        $member = $event->order->member;

        // 没有上级，则跳过
        if (! $member->parent_openid) {
            return;
        }

        // 上级查不到，跳过
        $parent = Member::query()->where('code', $member->parent_openid)->first();

        if (! $parent || $parent->identity == Member::IDENTITY_MEMBER) {
            return;
        }

        $ratio = $parent->ratio > 0 ? $parent->ratio : $config->ratio;

        // 创建分销订单
        SalesmanOrder::createByDto(new SalesmanOrderDto([
            'order_id' => $event->order->id,
            'ratio' => $ratio,
            'order_price' => $event->order->price,
            'user_id' => $parent->id,
            'custom_id' => $member->id,
        ]));
    }
}
