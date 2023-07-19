<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\MemberPackageTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Hyperf\DbConnection\Model\Model;

class MemberPackage extends Model
{
    use SearchableTrait, MemberPackageTrait;

    public const STATUS_AVAILABLE = 1;

    public const STATUS_UNAVAILABLE = 2;

    public const STATUS = [
        self::STATUS_AVAILABLE => '可用',
        self::STATUS_UNAVAILABLE => '不可用',
    ];

    public const CHANNEL_ORDER = 1;

    public const CHANNEL_REGISTER = 2;

    public const CHANNEL_ADMIN = 3;

    public const CHANNEL_SHELL = 4;

    public const CHANNEL_CDK = 5;

    public const CHANNEL_TASK = 6;

    public const CHANNEL = [
        self::CHANNEL_ORDER => '订单购买',
        self::CHANNEL_REGISTER => '注册赠送',
        self::CHANNEL_ADMIN => '后台操作',
        self::CHANNEL_SHELL => '脚本发放',
        self::CHANNEL_CDK => 'CDK兑换',
        self::CHANNEL_TASK => '任务发放',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_package';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'status', 'code', 'name', 'identity', 'channel', 'type', 'num', 'used', 'level', 'expired_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}
