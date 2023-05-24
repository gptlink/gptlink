<?php

namespace HyperfTest\Api;

use App\Http\Dto\OauthDto;
use App\Http\Service\MemberOauthService;
use App\Model\Member;
use Hyperf\Utils\Arr;
use HyperfTest\Factory\MemberFactory;
use HyperfTest\Mock\SmsServiceMock;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class LoginTest extends TestCase
{
    // 手机短信验证发送
    public function testWebWechatSendSmsCode()
    {
        SmsServiceMock::mockService(1234);

        $response = $this->post('/sms/send-code', [
            'mobile' => '13944700000'
        ]);
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '发送验证码',
            'category' => '微信/登陆相关',
            'params' => [],
            'desc' => '',
            'request' => [
                'mobile' => '手机号',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

    public function testWebWechatCheckSmsCode()
    {
        // 注册
        $platform = 'weixin';
        $mobile = '13944700000';
        $memberOrOath = (new MemberOauthService())->oauthLogin(new OauthDto([
            'nickname' => 'test',
            'avatar' => 'test.jpg',
            'openid' => 'test',
            'unionid' => 'test',
            'platform' => $platform,
        ]));
        // 短信
        $code = 1234;
        $cacheKey = sprintf('sms_code_login_%s', $mobile);
        cache()->set($cacheKey, [
            'code' => $code, 'lock_at' => time() + 60
        ], 300);

        $response = $this->post("/sms/login", [
            'mobile' => $mobile,
            'oauth_id' => Arr::get($memberOrOath, 'oauth_id'),
            'code' => $code,
            'platform' => '',
            'business_id' => 0,
            'source' => '',
        ]);

        MemberFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '验证码登陆',
            'category' => '微信/登陆相关',
            'params' => [],
            'desc' => '',
            'request' => [
                'mobile' => '手机号',
                'code' => '手机短信 code',
                'oauth_id' => '第一次注册时第三方登陆接口返回的 oauth_id',
                'platform' => BaseDto::mapDesc('注册平台', Member::PLATFORM),
                'business_id' => '商户ID，或模型ID',
                'source' => '用户来源，通常为给第三方的标识',
            ],
            'request_except' => ['source', 'platform', 'business_id'],
            'response' => [
                'user' => '用户信息',
                'user.nickname' => 'nickname',
                'user.avatar' => '头像',
                'user.mobile' => '手机号',
                'access_token' => 'token',
                'expire_in' => '失效时间'
            ],
        ]));
    }
}
