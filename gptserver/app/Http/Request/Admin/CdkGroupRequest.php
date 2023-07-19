<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class CdkGroupRequest extends BaseFormRequest
{
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'min:1', 'max:50'],
            'remark' => ['nullable', 'string', 'max:300'],
        ];

        if ($this->isMethod('post')) {
            $rules['num'] = ['required', 'integer', 'max:500'];
            $rules['package_id'] = ['required', 'integer'];
        }

        return $rules;
    }
}
