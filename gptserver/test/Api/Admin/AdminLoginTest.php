<?php

namespace Api\Admin;

use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class AdminLoginTest extends TestCase
{
    use LoginTrait;

    public function testAdminLogin()
    {
        $response = $this->post('/admin/login', [
            'username' => config('custom.admin.username'),
            'password' => config('custom.admin.password'),
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '管理员登录',
            'category' => '公共分类',
            'params' => [],
            'desc' => '',
            'request' => [
                'username' => '用户名',
                'password' => '密码',
            ],
            'request_except' => [],
            'response' => [
                'username' => '用户名',
                'access_token' => '登陆token',
                'expire' => '有效期',
            ],
        ]));
    }
}
