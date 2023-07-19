<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\Prompt;
use Hyperf\Validation\Rule;

class PromptStatusRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'status' => ['required', 'integer', Rule::in(array_keys(Prompt::STATUS))],
        ];
    }
}
