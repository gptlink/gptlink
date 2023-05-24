<?php

namespace HyperfTest\Mock;

use App\Http\Service\PaymentService;
use App\Http\Service\WechatPayService;

class WechatPayServiceMock
{

    public static function mock()
    {
        $service = \Mockery::mock(PaymentService::class)->makePartial();

        $service->allows()->unify(\Mockery::any())->andReturn([
            'return_code' => 'SUCCESS',
            'return_msg' => 'OK',
            'result_code' => 'SUCCESS',
            'mch_id' => '1220562801',
            'appid' => 'wxb595d641246eb016',
            'nonce_str' => 'hNlO80CJKh6SUFpe',
            'sign' => '9274BDFF61C478AF9546AF705B4A2B8B',
            'trade_type' => 'JSAPI',
            'prepay_id' => 'wx24111447053820d8685e516a2c470c0000',
        ]);

        app()->set(PaymentService::class, $service);
    }

}
