<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\Package;
use Hyperf\Validation\Rule;

class PackageStoreRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:50'],
            'show_name' => ['required', 'string', 'min:1', 'max:50'],
            'code' => ['nullable', 'string', 'max:20'],
            'sort' => ['required', 'integer', 'max:100'],
            'num' => ['required', 'integer', 'min:0', 'max:10000'],
            'price' => ['required', 'numeric'],
            'level' => ['required', 'integer', 'max:100'],
        ];
    }
}
