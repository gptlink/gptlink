<?php

namespace App\Http\Dto;

use App\Model\MemberPackage;
use App\Model\Package;
use Carbon\Carbon;
use Cblink\HyperfExt\Dto;

/**
 * @property string $code 标识码
 * @property int $num 数量
 * @property int $expired_day 时间
 * @property int $identity 身份
 * @property int $level 优先级
 * @property int $channel $渠道
 */
class MemberPackageDto extends Dto
{
    protected $fillable = [
        'status',
        'code',
        'name',
        'identity',
        'channel',
        'type',
        'num',
        'level',
        'expired_day',
    ];

    /**
     * @param $expiredAt
     * @return null|string
     */
    public function getExpiredAt($expiredAt = null)
    {
        if ($this->expired_day <= 0) {
            return '2099-01-01';
        }

        if ($expiredAt && $time = strtotime($expiredAt)) {
            return Carbon::createFromTimestamp($time)->addDays($this->expired_day)->toDateString();
        }

        return Carbon::now()->addDays($this->expired_day)->toDateString();
    }

    /**
     * @param $userId
     * @return array
     */
    public function toCreateData($userId)
    {
        return [
            'user_id' => $userId,
            'status' => MemberPackage::STATUS_AVAILABLE,
            'code' => $this->getItem('code'),
            'name' => $this->getItem('name'),
            'channel' => $this->getItem('channel'),
            'type' => $this->getItem('type'),
            'num' => $this->getItem('num'),
            'level' => $this->getItem('level'),
            'expired_at' => $this->getExpiredAt(),
        ];
    }

    /**
     * @param $userId
     * @param $packageId
     * @return array
     */
    public function toRecordData($userId, $packageId)
    {
        return [
            'user_id' => $userId,
            'package_id' => $packageId,
            'package_name' => $this->getItem('name'),
            'identity' => $this->getItem('identity', Package::IDENTITY_USER),
            'channel' => $this->getItem('channel'),
            'type' => $this->getItem('type'),
            'code' => $this->getItem('code'),
            'expired_day' => $this->getItem('expired_day'),
            'num' => $this->getItem('num'),
        ];
    }
}
