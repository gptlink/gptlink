<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\MemberOauthTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Hyperf\DbConnection\Model\Model;

class MemberOauth extends Model
{
    use MemberOauthTrait, SearchableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_oauth';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['member_id', 'platform', 'openid', 'unionid', 'nickname', 'avatar', 'appid'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
