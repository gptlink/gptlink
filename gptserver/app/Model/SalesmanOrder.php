<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\SalesmanOrderTrait;
use Cblink\ModelLibrary\Hyperf\PageableTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Hyperf\DbConnection\Model\Model;

class SalesmanOrder extends Model
{
    use SalesmanOrderTrait, PageableTrait, SearchableTrait;

    public const STATUS_PADDING = 1;

    public const STATUS_COMPLETE = 2;

    public const STATUS = [
        self::STATUS_PADDING => '待结算',
        self::STATUS_COMPLETE => '已结算',
    ];

    public const TYPE_SALESMAN = 1;

    public const TYPE = [
        self::TYPE_SALESMAN => '分销订单',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'salesman_order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'order_id', 'ratio', 'price', 'user_id', 'status', 'custom_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * @return \Hyperf\Database\Model\Relations\BelongsTo
     */
    public function custom()
    {
        return $this->belongsTo(Member::class, 'custom_id', 'id');
    }
}
