<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;

class CdkExchangeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'cdk' => ['required', 'string'],
        ];
    }
}
