<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class GivePackageRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'package_id' => ['required', 'integer'],
        ];
    }
}
