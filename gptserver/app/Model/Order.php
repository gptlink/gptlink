<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\OrderTrait;
use Cblink\ModelLibrary\Hyperf\PageableTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Cblink\ModelLibrary\Hyperf\WhenWithTrait;
use Hyperf\DbConnection\Model\Model;

class Order extends Model
{
    use OrderTrait, PageableTrait, SearchableTrait, WhenWithTrait;

    public const CHANNEL_WECHAT = 'wechat';

    public const CHANNEL_ALIPAY = 'alipay';

    public const CHANNEL = [
        self::CHANNEL_WECHAT => '微信支付',
        self::CHANNEL_ALIPAY => '支付宝',
    ];

    public const STATUS_UNPAID = 1;

    public const STATUS_PAID = 2;

    public const STATUS = [
        self::STATUS_UNPAID => '未支付',
        self::STATUS_PAID => '已支付',
    ];

    public const PAY_JSAPI = 'JSAPI';

    public const PAY_NATIVE = 'NATIVE';

    public const PAY_TYPE = [
        self::PAY_JSAPI => '微信内网页/小程序',
        self::PAY_NATIVE => '扫码支付',
    ];

    public const PLATFORM_GPT = 1;

    public const PLATFORM = [
        self::PLATFORM_GPT => 'gptlink',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['trade_no', 'user_id', 'channel', 'platform', 'business_id', 'pay_type', 'payload', 'paid_no', 'price', 'payment', 'status', 'package_id', 'package_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['payload' => 'json'];

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'user_id');
    }
}
