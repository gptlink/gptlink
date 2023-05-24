<?php

namespace App\Http\Dto;

use Cblink\Dto\Dto;

/**
 * @property string $id
 * @property int $user_id
 * @property string $system
 * @property string $first_id
 * @property string $parent_id
 * @property string $ask
 * @property string $answer
 */
class ChatLogDto extends Dto
{
    protected $fillable = [
        'id',
        'user_id',
        'system',
        'first_id',
        'parent_id',
        'ask',
        'answer',
    ];

    public function toData(): array
    {
        return [
            'id' => $this->getItem('id'),
            'user_id' => $this->getItem('user_id'),
            'system' => $this->getItem('system'),
            'first_id' => $this->getItem('first_id'),
            'parent_id' => $this->getItem('parent_id'),
            'ask' => $this->getItem('ask'),
            'answer' => $this->getItem('answer'),
        ];
    }
}
