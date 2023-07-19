<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class MemberOauthUnbindRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'member_oauth_id' => ['required', 'integer'],
        ];
    }
}
