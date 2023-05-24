<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\ChatGptModel;
use App\Model\Package;
use Hyperf\Validation\Rule;

class ChatGptModelStatusRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'status' => ['required', 'integer', Rule::in(array_keys(ChatGptModel::STATUS))],
        ];
    }
}
