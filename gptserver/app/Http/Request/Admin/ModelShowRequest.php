<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\Package;
use Hyperf\Validation\Rule;

class ModelShowRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'with_query' => ['nullable', 'array'],
        ];
    }
}
