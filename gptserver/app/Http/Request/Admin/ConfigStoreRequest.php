<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\Package;
use Hyperf\Validation\Rule;

class ConfigStoreRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'config' => ['required', 'array'],
        ];
    }
}
