<?php

namespace App\Listener\Order;

use App\Event\CdkUsedEvent;
use App\Model\MemberPackage;
use App\Model\Package;
use Hyperf\Event\Contract\ListenerInterface;

class CdkUsedListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            CdkUsedEvent::class,
        ];
    }

    /**
     * @param CdkUsedEvent $event
     * @return void
     */
    public function process(object $event)
    {
        $package = Package::findOrFail($event->cdk->package_id);

        $package->sendToUser($event->cdk->user_id, MemberPackage::CHANNEL_CDK);
    }
}
