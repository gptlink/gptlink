<?php

namespace App\Model\Repository;

use App\Event\CdkUsedEvent;
use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Model\Cdk;
use App\Model\Package;
use Carbon\Carbon;
use Hyperf\Utils\Str;

trait CdkTrait
{
    /**
     * 兑换cdk
     *
     * @param $code
     * @param $userId
     * @return null|\Hyperf\Database\Model\Collection|\Hyperf\Database\Model\Model|Package|Package[]
     * @throws \Throwable
     */
    public static function exchange($code, $userId)
    {
        $cdk = Cdk::query()->where('code', $code)->first();

        throw_unless($cdk, LogicException::class, ErrCode::CDK_INVALID);

        throw_if($cdk->status == Cdk::STATUS_USED, LogicException::class, ErrCode::CDK_INVALID);
        throw_if($cdk->status == Cdk::STATUS_EXPIRED, LogicException::class, ErrCode::CDK_IS_EXPIRED);

        $package = Package::find($cdk->package_id);

        throw_unless($package, LogicException::class, ErrCode::CDK_PACKAGE_NOT_FOUND);

        $cdk->used($userId);

        return $package;
    }

    /**
     * 生成cdk
     *
     * @param $packageId
     * @param $groupId
     * @param $expiredAt
     * @return Cdk|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function generate($packageId, $groupId = 0, $expiredAt = null)
    {
        return Cdk::query()->create([
            'package_id' => $packageId,
            'code' => Str::random(20),
            'status' => Cdk::STATUS_INIT,
            'group_id' => $groupId,
            'expired_at' => $expiredAt,
        ]);
    }

    /**
     * 使用cdk
     *
     * @param $userId
     */
    public function used($userId)
    {
        $this->status = Cdk::STATUS_USED;
        $this->user_id = $userId;
        $this->save();

        event(new CdkUsedEvent($this));
    }
}
