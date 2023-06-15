<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\Config;

class ConfigStoreRequest extends BaseFormRequest
{
    public function rules()
    {
        $rules = [
            'config' => ['required', 'array'],
        ];

        return array_merge($rules, match ((int) $this->route('type')) {
            Config::KEYWORD => [
                'config.keywords' => ['required', 'json'],
                'config.enable' => ['required', 'boolean'],
            ],
            default => [],
        });
    }

    public function messages(): array
    {
        return match ((int) $this->route('type')) {
            Config::KEYWORD => [
                'config.keywords.json' => '关键词内容必须是一个有效的 json',
            ],
            default => [],
        };
    }
}
