<?php

namespace Api;

use App\Http\Dto\Config\WebsiteConfigDto;
use App\Http\Request\Web\UserResetRequest;
use App\Model\Config;
use App\Model\Member;
use HyperfTest\Factory\MemberFactory;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class UsernameLoginTest extends TestCase
{

    public function testUsernameLogin()
    {
        $member = MemberFactory::createByData([
            'account_type' => Member::ACCOUNT_USERNAME,
        ]);

        $member->changePassword((string) $password = mt_rand(100000, 999999));

        $response = $this->post('/auth/login', [
            'nickname' => $member->nickname,
            'password' => (string) $password,
        ]);

        MemberFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '用户名登录',
            'category' => '公共分类',
            'desc' => '',
            'params' => [],
            'request' => [
                'nickname' => '用户名',
                'password' => '登录密码',
            ],
            'request_except' => [],
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

    public function testUsernameRegister()
    {
        Config::updateOrCreateByDto(new WebsiteConfigDto([
            'type' => Config::GPT_SECRET_KEY,
            'login_type' => WebsiteConfigDto::LOGIN_TYPE_USERNAME,
        ]));

        $response = $this->post('/auth/register', [
            'nickname' => 'test' . mt_rand(1000, 9999),
            'mobile' => '13100010002',
            'password' => 'test123456',
        ]);

        MemberFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '用户名/密码注册',
            'category' => '公共分类',
            'desc' => '',
            'params' => [],
            'request' => [
                'nickname' => '用户名',
                'mobile' => '预留手机号',
                'password' => '登录密码',
            ],
            'request_except' => [],
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

    public function testUsernameReset()
    {
        $member = MemberFactory::createByData([
            'account_type' => Member::ACCOUNT_USERNAME,
        ]);

        $member->changePassword((string) $password = mt_rand(100000, 999999));

        $response = $this->post('/auth/reset', [
            'nickname' => $member->nickname,
            'verify_type' => UserResetRequest::VERIFY_TYPE_PASSWORD,
            'verify' => (string) $password,
            'password' => 'testtest',
        ]);

        MemberFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '重置用户密码',
            'category' => '公共分类',
            'desc' => '',
            'params' => [],
            'request' => [
                'nickname' => '用户名',
                'password' => '新密码',
                'verify_type' => BaseDto::mapDesc('验证方式类型',UserResetRequest::VERIFY_TYPE),
                'verify' => '验证内容',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }
}
