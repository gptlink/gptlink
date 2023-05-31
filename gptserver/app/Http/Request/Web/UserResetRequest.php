<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;
use Cblink\HyperfExt\Rules\MobileRule;

class UserResetRequest extends BaseFormRequest
{
    protected function rules()
    {
        return [
            'nickname' => ['required', 'string', 'max:40'],
            'mobile' => ['required', new MobileRule()],
            'password' => ['required', 'string', 'min:6', 'max:40'],
        ];
    }
}
