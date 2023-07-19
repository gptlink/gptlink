<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class OrderIndexRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['nullable', 'array', 'max:150'],
            'package_id' => ['nullable', 'integer'],
            'created_at' => ['nullable', 'string'],
        ];
    }
}
