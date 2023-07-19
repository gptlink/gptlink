<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;
use Cblink\HyperfExt\Rules\MobileRule;

class SendSmsRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'mobile' => ['required', 'string', new MobileRule()],
        ];
    }
}
