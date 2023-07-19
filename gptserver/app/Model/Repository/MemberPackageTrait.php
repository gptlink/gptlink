<?php

namespace App\Model\Repository;

use App\Http\Dto\MemberPackageDto;
use App\Model\MemberPackage;
use App\Model\Package;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;

trait MemberPackageTrait
{
    /**
     * 查询是否还有套餐可用
     *
     * @param $userId
     * @param $type
     * @return bool
     */
    public static function existsPackage($userId, $type = Package::TYPE_CHAT)
    {
        return MemberPackage::query()
            ->where('user_id', $userId)
            ->where('status', MemberPackage::STATUS_AVAILABLE)
            ->where('type', $type)
            ->exists();
    }

    /**
     * 消费次数
     *
     * @param int $used
     */
    public function consumption(int $used = 1)
    {
        // 增加消费的次数
        MemberPackage::query()->where('id', $this->id)->increment('used', $used);

        // 如果次数用完，则更新状态
        if ($this->num > -1 && ($this->used + $used) >= $this->num) {
            $this->status = MemberPackage::STATUS_UNAVAILABLE;
            $this->save();
        }
    }

    /**
     * 创建套餐包
     *
     * @param $userId
     * @param MemberPackageDto $dto
     * @return Builder|MemberPackage|Model
     */
    public static function createByDto($userId, MemberPackageDto $dto)
    {
        return MemberPackage::query()->create($dto->toCreateData($userId));
    }

    /**
     * 更新套餐包
     *
     * @param $userId
     * @param MemberPackageDto $dto
     * @return Builder|\Hyperf\Database\Query\Builder|MemberPackage|Model|object
     */
    public static function updateByDto($userId, MemberPackageDto $dto)
    {
        logger()->info('更新套餐', [
            'user_id' => $userId,
            'dto' => $dto->toArray(),
        ]);

        if ($dto->code) {
            $memberPackage = MemberPackage::query()
                ->where('user_id', $userId)
                ->where('code', $dto->code)
                ->first();

            if ($memberPackage) {
                // 状态如果是无效的，更新为有效状态
                if ($memberPackage->status == MemberPackage::STATUS_UNAVAILABLE) {
                    $memberPackage->status = MemberPackage::STATUS_AVAILABLE;
                }

                // 如果不限制数量，则覆盖
                if ($dto->num == -1) {
                    $memberPackage->num = -1;
                }
                $memberPackage->channel = $dto->channel;
                $memberPackage->level = $dto->level;
                // 重新计算有效期，ps: 套餐不要随便改内容
                $memberPackage->expired_at = $dto->getExpiredAt($memberPackage->expired_at);
                $memberPackage->save();

                // 增加数量
                if ($dto->num > 0) {
                    MemberPackage::query()->where('id', $memberPackage->id)->increment('num', $dto->num);
                }

                return $memberPackage;
            }
        }

        return self::createByDto($userId, $dto);
    }
}
