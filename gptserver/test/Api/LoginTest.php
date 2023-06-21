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
        $mobile = '13944700000';
        $memberOrOath = MemberFactory::createOauth(0);
        // 短信
        $code = 1234;
        $cacheKey = sprintf('sms_code_login_%s', $mobile);
        cache()->set($cacheKey, [
            'code' => $code, 'lock_at' => time() + 60
        ], 300);

        $response = $this->post("/sms/login", [
            'mobile' => $mobile,
            'oauth_id' => base64_encode($memberOrOath->id),
            'code' => $code,
            'source' => '',
            'share_openid' => '',
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
                'source' => '用户来源，通常为给第三方的标识',
                'share_openid' => '分享人的openid',
            ],
            'request_except' => ['source', 'platform', 'business_id'],
            'response' => [
                'user' => '用户信息',
                'user.openid' => '用户ID',
                'user.nickname' => 'nickname',
                'user.avatar' => '头像',
                'access_token' => 'token',
                'expire_in' => '有效期',
                'token_type' => '认证方式',
            ],
        ]));
    }
}
