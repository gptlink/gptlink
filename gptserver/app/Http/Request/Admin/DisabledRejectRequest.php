<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class DisabledRejectRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'reason' => ['required', 'string', 'max:200'],
        ];
    }
}
