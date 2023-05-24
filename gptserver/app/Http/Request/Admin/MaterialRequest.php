<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\Material;
use Hyperf\Validation\Rule;

class MaterialRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => ['required', 'integer', Rule::in(array_keys(Material::TYPE))],
            'files' => ['required', 'array'],
            'files.*.file_url' => ['required', 'string'],
            'files.*.title' => ['required', 'string'],
        ];
    }
}
