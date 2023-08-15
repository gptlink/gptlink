<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class WithdrawAgreeRequest extends BaseFormRequest
{

    public function rules()
    {
        return [
            'paid_no' => ['required', 'string', 'max:150'],
        ];
    }

}
