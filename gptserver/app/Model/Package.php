<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\PackageTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Hyperf\DbConnection\Model\Model;

class Package extends Model
{
    use PackageTrait, SearchableTrait;

    public const PLATFORM_GPT = 1;

    public const PLATFORM = [
        self::PLATFORM_GPT => 'gptlink',
    ];

    public const IDENTITY_USER = 1;

    public const IDENTITY = [
        self::IDENTITY_USER => '用户',
    ];

    public const TYPE_CHAT = 1;

    public const TYPE = [
        self::TYPE_CHAT => '对话',
    ];

    public const CODE_NUM = 'num';

    public const CODE_DATE = 'date';

    public const CODE = [
        self::CODE_NUM => '按次数',
        self::CODE_DATE => '按天数',
    ];

    public const SHOW_OFF = 0;

    public const SHOW_ON = 1;

    public const SHOW = [
        self::SHOW_OFF => '不展示',
        self::SHOW_ON => '展示',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'package';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type', 'identity', 'code', 'show_name', 'show', 'sort', 'expired_day', 'num', 'price', 'level', 'platform', 'business_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * @return \Hyperf\Database\Model\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class, 'package_id', 'id');
    }
}
