<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\PromptCountTrait;
use Hyperf\DbConnection\Model\Model;

class PromptCount extends Model
{
    use PromptCountTrait;

    public const USER_MODEL_CACHE_COUNT = 'user_chat_model_count';

    public const USER_MODEL_CACHE_COUNT_TTL = 72;

    public $incrementing = false;

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prompt_count';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['prompt_id', 'likes', 'uses'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $keyType = 'string';

    protected $primaryKey = 'prompt_id';

    /**
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function prompt()
    {
        return $this->hasOne(Prompt::class, 'id', 'prompt_id');
    }
}
