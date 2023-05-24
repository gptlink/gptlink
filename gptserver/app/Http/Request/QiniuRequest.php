<?php

namespace App\Http\Request;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use Hyperf\Validation\Request\FormRequest;

class QiniuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'path' => ['required', 'string', sprintf('regex:/%s/', config('custom.qiniu.path'))],
        ];
    }

	public function messages(): array
	{
		return [
			'path.regex' => '上传路径不合法',
		];
	}
}
