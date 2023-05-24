<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\ChatGptModel;
use App\Model\Package;
use Hyperf\Validation\Rule;

class ChatGptStoreRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'icon' => ['nullable', 'string', 'max:200'],
            'name' => ['required', 'string', 'max:50'],
            'prompt' => ['required', 'string'],
            'system' => ['required', 'string', 'max:10000'],
            'platform' => ['required', 'integer', Rule::in(array_keys(ChatGptModel::PLATFORM))],
            'desc' => ['nullable', 'string', 'max:200'],
            'remark' => ['nullable', 'string', 'max:200'],
            'type' => ['required', 'integer', Rule::in(array_keys(ChatGptModel::TYPE))],
        ];
    }
}
