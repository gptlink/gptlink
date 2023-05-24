<?php

namespace App\Http\Request\Web;


use App\Http\Request\BaseFormRequest;

class ChatGptModelStoreRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:255'],
            'desc' => ['required', 'string', 'max:255'],
            'system' => ['required', 'string'],
            'prompt' => ['required', 'string'],
        ];
    }
}
