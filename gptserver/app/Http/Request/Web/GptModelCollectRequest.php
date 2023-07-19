<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;

class GptModelCollectRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'prompt_id' => ['required', 'string', 'size:16'],
        ];
    }
}
