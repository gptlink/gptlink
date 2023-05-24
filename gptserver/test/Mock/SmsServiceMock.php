<?php

namespace HyperfTest\Mock;


use App\Http\Control\Web\WechatController;
use App\Http\Service\SmsService;

class SmsServiceMock
{
    /**
     * @return void
     */
    public static function mockService($code)
    {
        $service = \Mockery::mock(SmsService::class)->makePartial();

        $service->allows()->sendLoginSms(\Mockery::any())
            ->andReturn($code);

        app()->set(SmsService::class, $service);
    }


}