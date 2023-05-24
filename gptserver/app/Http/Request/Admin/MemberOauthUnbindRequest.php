<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\Package;
use Hyperf\Validation\Rule;

class MemberOauthUnbindRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'member_oauth_id' => ['required', 'integer'],
        ];
    }
}
