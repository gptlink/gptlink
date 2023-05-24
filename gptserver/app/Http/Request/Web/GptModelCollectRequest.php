<?php

namespace App\Http\Request\Web;


use App\Http\Request\BaseFormRequest;
use App\Model\Order;
use App\Model\Package;
use Hyperf\Validation\Rule;

class GptModelCollectRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'model_id' => ['required', 'string', 'size:16'],
        ];
    }
}
