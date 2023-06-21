<?php

namespace App\Http\Request\Salesman;

use App\Http\Request\BaseFormRequest;
use App\Model\Withdraw;
use Cblink\HyperfExt\Rules\MobileRule;
use Hyperf\Validation\Rule;

class WithdrawalApplyRequest extends BaseFormRequest
{
    public function rules()
    {
        $rules = [
            'price' => ['required', 'min:0.01', 'max:10000'],
            'channel' => ['required', Rule::in(array_keys(Withdraw::CHANNEL))],
            'config' => ['required', 'array'],
        ];

        if ($this->input('channel') == Withdraw::CHANNEL_ALIPAY) {
            $rules = array_merge($rules, [
                'config.name' => ['required', 'string', 'max:30'],
                'config.account' => ['required', new MobileRule()],
            ]);
        }

        return $rules;
    }
}
