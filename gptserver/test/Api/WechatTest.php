<?php

namespace HyperfTest\Api;

use HyperfTest\LoginTrait;
use HyperfTest\Mock\WechatControllerMock;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class WechatTest extends TestCase
{
    use LoginTrait;

    public function testWebWechatJssdk()
    {
        WechatControllerMock::mockController();

        $response = $this->get('/wechat/jssdk', [
            'url' => 'dev-api.chatgpt.cblink.net',
            'apis' => [],
        ]);
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => 'jssdk',
            'category' => '微信相关',
            'params' => [],
            'desc' => '',
            'request' => [
                'url' => '域名地址',
                'apis' => 'api集合',
            ],
            'request_except' => [],
            'response' => ['data'],
        ]));
    }

    public function testWebWechatRedirect()
    {
        WechatControllerMock::mockController();

        $response = $this->get('/wechat/weixin/redirect', [
            'redirect_url' => '接收 code 的前端页面地址',
        ]);

        $this->assertTrue(true);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '跳转到微信授权',
            'category' => '微信/登陆相关',
            'params' => [
                2 => BaseDto::mapDesc('渠道', [
                    // 'weixinweb' => '微信pc端',
                    'weixin' => 'h5 公众号',
                ]),
            ],
            'desc' => '',
            'request' => [
                'redirect_url' => '接收 code 的前端页面地址',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

    // 扫码登陆
    public function testWebWechatQrcode()
    {
        WechatControllerMock::mockController();

        $response = $this->get('/wechat/weixin/qrcode', [
            'redirect_url' => '接收 code 的前端页面地址',
        ]);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '获取微信二维码',
            'category' => '微信/登陆相关',
            'params' => [
                2 => BaseDto::mapDesc('渠道', [
                    'weixinweb' => '微信pc端',
                    // 'weixin' => 'h5 公众号',
                ]),
            ],
            'desc' => '',
            'request' => [
                'redirect_url' => '接收 code 的前端页面地址',
            ],
            'request_except' => [],
            'response' => ['qr_code_url' => '二维码地址'],
        ]));
    }

    // 登陆
    public function testWebWechatLogin()
    {
        WechatControllerMock::mockController();

        $response = $this->post('/wechat/weixin/login', [
            'code' => 'xxxx',
        ]);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '使用code登陆',
            'category' => '微信/登陆相关',
            'params' => [
                2 => BaseDto::mapDesc('渠道', [
                    'weixinweb' => '微信pc端',
                    'weixin' => 'h5 公众号',
                ]),
            ],
            'desc' => '',
            'request' => [
                'code' => '微信回跳返回的code',
            ],
            'request_except' => [],
            'response' => [
                'oauth_id' => '认证 id，返回此字段时候需要前往手机号登录页',
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
