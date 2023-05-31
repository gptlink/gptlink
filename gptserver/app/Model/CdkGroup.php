<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\CdkGroupTrait;
use Cblink\ModelLibrary\Hyperf\PageableTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Cblink\ModelLibrary\Hyperf\WhenWithTrait;
use Hyperf\DbConnection\Model\Model;

class CdkGroup extends Model
{
    use CdkGroupTrait, SearchableTrait, WhenWithTrait, PageableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cdk_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'num', 'package_id', 'price', 'remark'];

    public function package()
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }
}
