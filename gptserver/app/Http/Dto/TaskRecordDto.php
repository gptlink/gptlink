<?php

namespace App\Http\Dto;

use Cblink\Dto\Dto;

/**
 * @property int $user_id
 * @property int $task_id
 * @property string $type
 * @property string $package_name
 * @property string $expired_day
 * @property string $num
 */
class TaskRecordDto extends Dto
{
    protected $fillable = [
        'user_id', 'task_id', 'type', 'package_name', 'expired_day', 'num',
    ];

    public function getFillableData()
    {
        return [
            'user_id' => $this->getItem('user_id'),
            'task_id' => $this->getItem('task_id'),
            'type' => $this->getItem('type'),
            'package_name' => $this->getItem('package_name'),
            'expired_day' => $this->getItem('expired_day'),
            'num' => $this->getItem('num'),
        ];
    }
}
