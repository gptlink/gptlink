<?php

namespace App\Http\Request;

use App\Model\Material;
use Hyperf\Validation\Rule;

class MaterialIndexRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => ['required', 'integer', Rule::in(array_keys(Material::TYPE))],
        ];
    }
}
