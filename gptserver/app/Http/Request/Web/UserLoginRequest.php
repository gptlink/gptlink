<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;

class UserLoginRequest extends BaseFormRequest
{
    public function messages(): array
    {
        return [
            'password.min' => '密码不能小于6位',
            'password.max' => '密码不能小于8位',
        ];
    }

    protected function rules()
    {
        return [
            'nickname' => ['required', 'string', 'max:40'],
            'password' => ['required', 'string', 'min:6', 'max:40'],
        ];
    }
}
