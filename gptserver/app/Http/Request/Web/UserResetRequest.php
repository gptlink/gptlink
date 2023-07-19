<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;
use Hyperf\Validation\Rule;

class UserResetRequest extends BaseFormRequest
{
    public const VERIFY_TYPE_PASSWORD = 1;

    public const VERIFY_TYPE_MOBILE = 2;

    public const VERIFY_TYPE = [
        self::VERIFY_TYPE_PASSWORD => '旧密码验证',
        self::VERIFY_TYPE_MOBILE => '手机号验证',
    ];

    protected function rules()
    {
        return [
            'nickname' => ['required', 'string', 'max:40'],
            'verify_type' => ['required', Rule::in(array_keys(self::VERIFY_TYPE))],
            'verify' => ['required', 'string', 'max:40'],
            'password' => ['required', 'string', 'min:6', 'max:40'],
            'code' => ['nullable', 'string', 'max:6'],
        ];
    }
}
