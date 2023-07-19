<?php

namespace App\Http\Dto;

use Cblink\HyperfExt\Dto;

/**
 * @property string $parent_code 父级 code
 * @property int $member_id 会员 id
 */
class UserRegisterTaskDto extends Dto
{
    protected $fillable = [
        'parent_code', 'member_id',
    ];
}
