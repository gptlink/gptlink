<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;

class ImageRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'size' => ['required', 'int', 'min:1000'],
            'width' => ['required', 'int', 'min:10'],
            'height' => ['required', 'int', 'min:10'],
            'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'regex:/^data:image\/(png|jpeg);base64,/'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.regx' => '图片类型错误',
        ];
    }
}
