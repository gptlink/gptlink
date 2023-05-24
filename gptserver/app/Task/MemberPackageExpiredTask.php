<?php

namespace App\Task;

use App\Model\MemberPackage;
use Carbon\Carbon;
use Hyperf\Crontab\Annotation\Crontab;

#[Crontab(name: 'memberPackageExpired', rule: '0 */1 * * *', callback: 'execute', memo: '用户套餐过期', singleton: true, onOneServer: true, enable: true)]
class MemberPackageExpiredTask
{
    public function execute()
    {
        $memberPackages = MemberPackage::query()
            ->where('status', MemberPackage::STATUS_AVAILABLE)
            ->whereDate('expired_at', '<', Carbon::now()->toDateString())
			->update([
				'status' => MemberPackage::STATUS_UNAVAILABLE,
				'num'    => 0,
				'used'   => 0,
			]);

        logger()->info('处理过期的套餐', [
            'date' => Carbon::now()->toDateTimeString(),
            'rows' => $memberPackages,
        ]);
    }
}
