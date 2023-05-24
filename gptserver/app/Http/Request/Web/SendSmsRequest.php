<?php

namespace App\Http\Request\Web;


use App\Http\Request\BaseFormRequest;
use App\Model\Order;
use App\Model\Package;
use Cblink\HyperfExt\Rules\MobileRule;
use Hyperf\Validation\Rule;

class SendSmsRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'mobile' => ['required', 'string', new MobileRule()],
        ];
    }
}
