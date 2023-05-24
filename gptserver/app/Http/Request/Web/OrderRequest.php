<?php

namespace App\Http\Request\Web;


use App\Http\Request\BaseFormRequest;
use App\Model\Order;
use App\Model\Package;
use Hyperf\Validation\Rule;

class OrderRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'package_id' => ['required', 'integer', Rule::exists((new Package())->getTable(), 'id')],
            'channel' => ['required', Rule::in(array_keys(Order::CHANNEL))],
            'pay_type' => ['required', Rule::in(array_keys(Order::PAY_TYPE))],
            // 支付宝的user_id 或者 微信的openid
            'user_id' => ['nullable', 'string'],
        ];
    }
}
