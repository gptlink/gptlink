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
            'mobile' => ['nullable', new MobileRule()],
            'password' => ['required', 'string', 'min:6', 'max:40'],
        ];
    }

    public function messages(): array
    {
        return [
            'nickname.unique' => '用户名已被使用，请更换后再试',
        ];
    }
}
