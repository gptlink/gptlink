<?php

namespace App\Http\Request\Web;

use App\Http\Request\BaseFormRequest;

class MemberConfigMasterImageRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'material_id' => ['required', 'integer'],
        ];
    }
}
