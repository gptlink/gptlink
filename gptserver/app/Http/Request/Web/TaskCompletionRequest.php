<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;
use App\Model\Task;
use Hyperf\Validation\Rule;

class TaskCompletionRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => ['required', 'string', Rule::in(array_keys(Task::TYPE))],
        ];
    }
}
