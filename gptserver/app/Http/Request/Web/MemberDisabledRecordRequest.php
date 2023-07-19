<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;

class MemberDisabledRecordRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'mobile' => ['nullable', 'string', 'size:11'],
            'appeal' => ['required', 'string', 'min:10', 'max:200'],
        ];
    }
}
