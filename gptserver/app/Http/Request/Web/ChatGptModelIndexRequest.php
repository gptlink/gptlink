<?php

namespace App\Http\Request\Web;


use App\Http\Request\BaseFormRequest;
use App\Model\ChatGptModel;
use Hyperf\Validation\Rule;

class ChatGptModelIndexRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'platform' => ['required', Rule::in(ChatGptModel::PLATFORM_GPT, ChatGptModel::PLATFORM_MAGIC)],
        ];
    }
}
