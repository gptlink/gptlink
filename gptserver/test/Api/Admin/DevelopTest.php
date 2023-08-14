<?php

namespace HyperfTest\Api\Admin;

use HyperfTest\LoginTrait;
use HyperfTest\Mock\DevelopServiceMock;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class DevelopTest extends TestCase
{
    use LoginTrait;

    public function testAdminDevelopGetPackage()
    {
        /*
        $this->adminLogin();

        $response = $this->get('/admin/develop/package');

        $this->assertApiSuccess($response);

        OrderFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '套餐余额',
            'category' => '开发者套餐',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => '订单id',
                'name' => '套餐名称',
                'num' => '套餐数量',
                'used' => '已使用数量',
                'expired_at' => '过期时间',
            ],
        ]));
        */
        $this->assertTrue(true);
    }

    public function testAdminDevelopGetProfile()
    {
        $this->adminLogin();
        DevelopServiceMock::mock();

        $response = $this->get('/admin/develop/profile');
        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '个人信息',
            'category' => '开发者接口',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                "openid" => "openid",
                "nickname" => "昵称",
                "avatar" => "头像",
                "status" => '状态， 1 正常 2 禁用',
            ],
        ]));
    }

    public function testAdminDevelopGetMyPackage()
    {
        $this->adminLogin();
        DevelopServiceMock::mock();

        $response = $this->get('/admin/develop/package');

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '套餐余额',
            'category' => '开发者接口',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'chat' => '兑换套餐',
                'chat.id' => '订单id',
                'chat.name' => '套餐名称',
                'chat.num' => '套餐数量',
                'chat.used' => '已使用数量',
                'chat.expired_at' => '过期时间',
                'sms' => '短信套餐',
                'sms.id' => '订单id',
                'sms.name' => '套餐名称',
                'sms.num' => '套餐数量',
                'sms.used' => '已使用数量',
                'sms.expired_at' => '过期时间',
            ],
        ]));
    }

    public function testAdminDevelopGetRcord()
    {
        $this->adminLogin();
        DevelopServiceMock::mock();

        $response = $this->get('/admin/develop/record');
        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '我的套餐记录',
            'category' => '开发者接口',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                "*.id" => 'id',
                "*.user_id" => '用户id',
                "*.package_id" => '套餐包id',
                "*.package_name" => "使用的套餐包名字",
                "*.channel" => '获取渠道筛选 , 1 : 订单购买 , 2 : 注册赠送 , 3 : 后台操作 , 4 : 脚本发放 , 5 : CDK兑换 , 6 : 任务发放 , 7 : 短信 , 8 : 对话 , 9 : AI绘画-文生图 , 10 : 一键同款 , 11 : AI绘画-下载原图 , 12 : AI绘画-图生图 , 13 : AI视频-视频生视频',
                "*.type" => '套餐类型，1 : ChatGPT-H5，2 : ChatGPT-小程序，3 : 短信，10 : AI图片',
                "*.num" => '数量，-1表示不限制',
                "*.symbol" => '1 : 收入 2 : 支出',
                "*.created_at" => "创建时间"
            ],
        ]));
    }
}
