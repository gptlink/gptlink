<?php

namespace App\Http\Request\Admin;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Request\BaseFormRequest;
use App\Model\Package;
use App\Model\Task;
use Hyperf\Validation\Rule;

class TaskRecordIndexRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => ['nullable', 'string', Rule::in(array_keys(Task::TYPE))],
            'user_id' => ['nullable', 'integer'],
            'created_at' => ['nullable', 'string'],
        ];
    }

}
