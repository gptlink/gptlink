<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\Package;
use Hyperf\Validation\Rule;

class MemberOauthRecordRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['nullable', 'integer'],
        ];
    }
}
