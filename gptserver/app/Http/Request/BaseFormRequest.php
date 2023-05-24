<?php

namespace App\Http\Request;

use Hyperf\Validation\Request\FormRequest;

class BaseFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
}
