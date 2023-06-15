<?php

declare (strict_types=1);
namespace App\Model;

use App\Model\Repository\MaterialTrait;
use Cblink\ModelLibrary\Hyperf\PageableTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Hyperf\DbConnection\Model\Model;

class Material extends Model
{
    use MaterialTrait, SearchableTrait, PageableTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'material';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'title', 'file_url', 'size', 'format', 'width', 'height', 'content'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}
