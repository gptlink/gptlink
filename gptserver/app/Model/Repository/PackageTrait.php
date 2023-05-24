<?php

namespace App\Model\Repository;

use App\Http\Dto\MemberPackageDto;
use App\Http\Dto\PackageDto;
use App\Model\MemberPackage;
use App\Model\MemberPackageRecord;
use App\Model\Package;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;

trait PackageTrait
{
    /**
     * 获取分单位的金额
     *
     * @return int
     */
    public function getIntPrice()
    {
        return (int) bcmul((string) $this->price, '100');
    }

    /**
     * 给用户发放套餐包
     *
     * @param $userId
     * @param int $channel
     * @return Builder|\Hyperf\Database\Query\Builder|MemberPackage|Model|object
     */
    public function sendToUser($userId, int $channel = MemberPackage::CHANNEL_ORDER)
    {
        $dto = new MemberPackageDto([
            'code' => $this->code,
            'name' => $this->show_name,
            'channel' => $channel,
            'identity' => $this->identity,
            'type' => $this->type,
            'num' => $this->num,
            'level' => $this->level,
            'expired_day' => $this->expired_day,
        ]);

        // 赠送套餐
        $result = MemberPackage::updateByDto($userId, $dto);
        // 增加记录
        MemberPackageRecord::createByPackageDto($userId, $this->id, $dto);

        return $result;
    }

    /**
     * @param PackageDto $dto
     * @return Package|Builder|Model
     */
    public static function createByDto(PackageDto $dto)
    {
        return Package::query()->create($dto->toData());
    }

    /**
     * 编辑
     *
     * @param PackageDto $dto
     * @return Package
     */
    public function updateByDto(PackageDto $dto)
    {
        $this->update($dto->getUpdateData());

        return $this->refresh();
    }
    /**
     * 修改状态
     *
     * @param int $show
     * @return \App\Model\Package
     */
    public function updateShow(int $show)
    {
        $this->update(['show' => $show]);
        return $this->refresh();
    }
}
