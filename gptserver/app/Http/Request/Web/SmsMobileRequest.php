<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;
use Cblink\HyperfExt\Rules\MobileRule;

class SmsMobileRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'mobile' => ['required', 'string', new MobileRule()],
            'oauth_id' => ['required', 'string'],
            'code' => ['required', 'integer', 'min:1000', 'max:9999'],
            'share_openid' => ['nullable', 'string'],
            'source' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.min' => '请输入正确的验证码',
            'code.max' => '请输入正确的验证码',
            'code.integer' => '请输入正确的验证码',
        ];
    }
}
