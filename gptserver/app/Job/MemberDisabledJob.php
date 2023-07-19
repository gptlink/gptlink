<?php

namespace App\Job;

use App\Http\Service\NotifyService;
use Hyperf\AsyncQueue\Job;

class MemberDisabledJob extends Job
{
    /**
     * @var array 消息通知数据
     */
    protected $notifyData;

    public function __construct($notifyData)
    {
        $this->notifyData = $notifyData;
    }

    public function handle()
    {
        // 发送飞书通知
        $service = app()->get(NotifyService::class);
        $service->sendNotify($this->notifyData);
    }
}
