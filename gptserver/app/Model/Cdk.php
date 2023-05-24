<?php

declare (strict_types=1);
namespace App\Model;

use App\Model\Repository\CdkTrait;
use Hyperf\DbConnection\Model\Model;
/**
 */
class Cdk extends Model
{
    use CdkTrait;

    const STATUS_INIT = 1;
    const STATUS_USED = 2;
    const STATUS_EXPIRED = 3;
    const STATUS = [
        self::STATUS_INIT => '未使用',
        self::STATUS_USED => '已使用',
        self::STATUS_EXPIRED => '已过期',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cdk';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['package_id', 'code', 'user_id', 'status', 'expired_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public $timestamps = false;
}
