<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;
use App\Model\Member;
use Cblink\HyperfExt\Rules\MobileRule;
use Hyperf\Validation\Rule;

class UserRegisterRequest extends BaseFormRequest
{
    protected function rules()
    {
        return [
            'nickname' => ['required', 'string', 'max:40', Rule::unique((new Member())->getTable(), 'nickname')],
            'mobile' => ['required', new MobileRule(), Rule::unique((new Member())->getTable(), 'mobile')],
            'password' => ['required', 'string', 'min:6', 'max:40'],
        ];
    }

    public function messages(): array
    {
        return [
            'nickname.unique' => '用户信息已存在，请更换后重试',
            'mobile.unique' => '用户信息已存在，请更换后重试',
        ];
    }
}
