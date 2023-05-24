<?php

declare (strict_types=1);
namespace App\Model;

use App\Model\Repository\TaskTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Hyperf\DbConnection\Model\Model;

class Task extends Model
{
    use TaskTrait;

    const TYPE_REGISTER = 'register';
    const TYPE_INVITE = 'invite';
    const TYPE_SHARE = 'share';

    const TYPE = [
        self::TYPE_REGISTER => '新用户注册',
        self::TYPE_INVITE => '邀请朋友',
        self::TYPE_SHARE => '每日分享',
    ];

    const PLATFORM_H5 = 'h5';
    const PLATFORM_PC = 'pc';
    const PLATFORM_MINI = 'mini';
    const PLATFORM = [
        self::PLATFORM_H5 => 'H5',
        self::PLATFORM_PC => 'PC',
        self::PLATFORM_MINI => '小程序',
    ];

    const STATUS_ON = 1;
    const STATUS_OFF = 2;
    const STATUS = [
        self::STATUS_ON => '启用',
        self::STATUS_OFF => '关闭',
    ];

    const RULE_VALID_TYPE_FOREVER = 'forever';
    const RULE_VALID_TYPE_EVERYDAY = 'everyday';
    // 规则次数
    const RULE = [
        self::TYPE_REGISTER => ['frequency' => 1, 'valid_type' => self::RULE_VALID_TYPE_FOREVER],
        self::TYPE_INVITE => ['frequency' => 0, 'valid_type' => self::RULE_VALID_TYPE_FOREVER], // 邀请
        self::TYPE_SHARE => ['frequency' => 1, 'valid_type' => self::RULE_VALID_TYPE_EVERYDAY]   // 1
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'title', 'desc', 'platform', 'share_image', 'status', 'rule', 'package_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['rule' => 'array'];

    /**
     * 套餐
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function package()
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

    /**
     * 记录
     *
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function record()
    {
        return $this->hasMany(TaskRecord::class, 'task_id', 'id');
    }

}
