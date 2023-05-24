<?php

namespace App\Http\Request;

use Hyperf\Validation\Request\FormRequest;

class ChatRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'stream' => ['nullable', 'boolean'],
            'last_id' => ['nullable', 'string'],
            'message' => ['required', 'string'],
            'model_id' => ['nullable', 'string'],
            'request_id' => ['nullable', 'string'],
        ];
    }

}
