<?php

namespace App\Http\Request\Web;


use App\Http\Request\BaseFormRequest;
use App\Model\Order;
use App\Model\Package;
use Hyperf\Validation\Rule;

class MemberConfigMasterImageRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'material_id' => ['required', 'integer'],
        ];
    }
}
