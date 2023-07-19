<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\ChatLogTrait;
use Hyperf\DbConnection\Model\Model;

class ChatLog extends Model
{
    use ChatLogTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chat_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'first_id',
        'parent_id',
        'ask',
        'system',
        'answer',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}
