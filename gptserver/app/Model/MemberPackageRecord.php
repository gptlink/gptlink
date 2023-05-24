<?php

declare (strict_types=1);
namespace App\Model;

use App\Model\Repository\MemberPackageRecordTrait;
use Cblink\ModelLibrary\Hyperf\PageableTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Cblink\ModelLibrary\Hyperf\WhenWithTrait;
use Hyperf\DbConnection\Model\Model;
/**
 */
class MemberPackageRecord extends Model
{
    use MemberPackageRecordTrait, PageableTrait, SearchableTrait, WhenWithTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_package_record';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'package_id', 'package_name', 'identity', 'channel', 'type', 'code', 'expired_day', 'num'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public $timestamps = false;

	public function member()
	{
		return $this->hasOne(Member::class, 'id', 'user_id');
	}
}
