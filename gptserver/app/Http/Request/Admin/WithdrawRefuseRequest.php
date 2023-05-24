<?php

namespace App\Http\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class WithdrawRefuseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'refuse' => ['required', 'string', 'max:150'],
        ];
    }
}
