<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class MemberOauthRecordRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['nullable', 'integer'],
        ];
    }
}
