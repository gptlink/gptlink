<?php

namespace HyperfTest\Mock;

use App\Http\Control\Web\WechatController;

class WechatControllerMock
{
    public static function mockController()
    {
        $controller = \Mockery::mock(WechatController::class)->makePartial();

        $controller->allows()->jssdk(\Mockery::any(), \Mockery::any())
            ->andReturn(['err_code' => 0, 'data' => ['data' => [
                'debug' => false,
                'beta' => false,
                'jsApiList' => [],
                'openTagList' => [],
                'appId' => 'test',
                'nonceStr' => 'test',
                'timestamp' => 1680245160,
                'url' => 'http://dev-api.chatgpt.cblink.net',
                'signature' => 'test',
            ]]]);
        $controller->allows()->redirect(\Mockery::any(), \Mockery::any())
            ->andReturn([]);

        $controller->allows()->qrcode(\Mockery::any(), \Mockery::any())
            ->andReturn(['err_code' => 0, 'data' => ['qr_code_url' => 'test.com']]);

        $controller->allows()->login(\Mockery::any(), \Mockery::any(), \Mockery::any())
            ->andReturn(['err_code' => 0, 'data' => [
                'oauth_id' => 'test',
                'user' => [
                    'nickname' => 'nickname',
                    'avatar' => '头像',
                    'mobile' => '手机号',
                ],
                'access_token' => 'token',
                'expire_in' => '2024-12-12 00:00:00',
            ]]);

        app()->set(WechatController::class, $controller);
    }
}
