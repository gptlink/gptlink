<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class DisabledRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'reason' => ['required', 'string', 'max:200'],
        ];
    }
}
