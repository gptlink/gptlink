<?php

namespace App\Job;

use App\Model\MemberPackage;
use App\Model\Package;
use Hyperf\AsyncQueue\Job;

/**
 *
 */
class MemberConsumptionJob extends Job
{
    /**
     * @var int
     */
    protected $userId;

    /**
     * @var int
     */
    protected $type;

    public function __construct($userId, $type = Package::TYPE_CHAT)
    {
        $this->userId = $userId;
        $this->type = $type;
    }

    public function handle()
    {
        $memberPackage = MemberPackage::query()
            ->where('user_id', $this->userId)
            ->where('type', $this->type)
            ->where('status', MemberPackage::STATUS_AVAILABLE)
            ->orderByDesc('level')
            ->first();

        // 如果没有可用的则打一下日志
        if (! $memberPackage) {
            logger()->info('扣费失败', [
                'user_id' => $this->userId,
                'type' => $this->type,
            ]);
        }

        // 消费
        $memberPackage->consumption();
    }
}
