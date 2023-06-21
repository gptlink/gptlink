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
        $unique = Rule::unique((new Member())->getTable(), 'nickname')
            ->ignore(Member::ACCOUNT_MOBILE,'account_type');

        return [
            'nickname' => ['required', 'string', 'max:40', $unique],
            'mobile' => ['nullable', new MobileRule()],
            'password' => ['required', 'string', 'min:6', 'max:40'],
            'code' => ['nullable', 'string', 'max:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'nickname.unique' => '用户名已被使用，请更换后再试',
        ];
    }
}
