<?php

namespace App\Http\Request\Admin;

use App\Http\Request\BaseFormRequest;
use App\Model\Package;
use Hyperf\Validation\Rule;

class PackageRecordRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'nickname' => ['nullable', 'string', 'min:1', 'max:50'],
            'mobile' => ['nullable', 'string'],
            'channel' => ['nullable', 'string', 'max:20'],
            'type' => ['nullable', 'integer', Rule::in(array_keys(Package::TYPE))],
            'user_id' => ['nullable', 'integer'],
        ];
    }
}
