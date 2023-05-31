<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;

class UserLoginRequest extends BaseFormRequest
{
    protected function rules()
    {
        return [
            'nickname' => ['required', 'string', 'max:40'],
            'password' => ['required', 'string', 'min:6', 'max:40'],
        ];
    }
}
