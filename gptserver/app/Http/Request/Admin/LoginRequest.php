<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class LoginRequest extends BaseFormRequest
{
    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'max:100'],
        ];
    }
}
