<?php

namespace App\Http\Request\Admin;

use App\Base\Consts\StatisticsConst;
use App\Http\Request\BaseFormRequest;
use Hyperf\Validation\Rule;

class StatisticsRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => ['required', 'array', Rule::in([StatisticsConst::MEMBER_COUNT, StatisticsConst::PAYMENT_COUNT])],
        ];
    }
}
