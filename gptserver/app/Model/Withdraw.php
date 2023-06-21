<?php

declare (strict_types=1);
namespace App\Model;

use Cblink\ModelLibrary\Hyperf\PageableTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Hyperf\DbConnection\Model\Model;
/**
 */
class Withdraw extends Model
{
    use PageableTrait, SearchableTrait;

    const CHANNEL_ALIPAY = 'alipay';

    const CHANNEL = [
        self::CHANNEL_ALIPAY => '支付宝',
    ];


    const STATUS_PADDING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_TRANSFER = 3;
    const STATUS = [
        self::STATUS_PADDING => '待审核',
        self::STATUS_SUCCESS => '已审核',
        self::STATUS_TRANSFER => '已转账',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'withdraw';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['serial_no', 'price', 'channel', 'config', 'status', 'paid_no', 'user_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'json',
    ];
}
