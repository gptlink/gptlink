<?php

namespace Api\Admin;

use App\Http\Dto\Config\SalesmanDto;
use App\Model\Config;
use App\Model\Member;
use App\Model\Order;
use App\Model\SalesmanOrder;
use HyperfTest\Factory\MemberFactory;
use HyperfTest\Factory\OrderFactory;
use HyperfTest\Factory\PackageFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class SalesmanTest extends TestCase
{
    use LoginTrait;

    public function testAdminSalesmanIndex()
    {
        $this->adminLogin();

        $user = MemberFactory::createByData();
        $user->setSalesman();

        $response = $this->get('/admin/salesman/user', [
            'mobile' => '',
            'nickname' => '',
        ]);

        MemberFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '分销员列表',
            'category' => '分销管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'mobile' => '',
                'nickname' => '',
            ],
            'request_except' => ['nickname', 'mobile'],
            'response' => [
                '*.id' => '用户 id',
                '*.nickname' => '用户昵称',
                '*.avatar' => '用户头像',
                '*.mobile' => '用户手机号',
                '*.status' => BaseDto::mapDesc('状态', Member::STATUS),
                '*.platform' => BaseDto::mapDesc('注册平台', Member::PLATFORM),
                '*.account_type' => BaseDto::mapDesc('账号类型', Member::ACCOUNT_TYPE),
                '*.balance' => '余额',
                '*.ratio' => '利率',
                '*.created_at' => '创建时间',
            ],
        ]));
    }


    public function testAdminSalesmanShow()
    {
        $this->adminLogin();

        $user = MemberFactory::createByData();
        $user->setSalesman();

        $response = $this->get(sprintf('/admin/salesman/user/%s', $user->id));

        MemberFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '分销员详情',
            'category' => '分销管理',
            'params' => [
                4 => '用户ID',
            ],
            'desc' => '',
            'request' => [
                'mobile' => '',
                'nickname' => '',
            ],
            'request_except' => [],
            'response' => [
                'id' => '用户 id',
                'nickname' => '用户昵称',
                'avatar' => '用户头像',
                'mobile' => '用户手机号',
                'status' => BaseDto::mapDesc('状态', Member::STATUS),
                'platform' => BaseDto::mapDesc('注册平台', Member::PLATFORM),
                'account_type' => BaseDto::mapDesc('账号类型', Member::ACCOUNT_TYPE),
                'balance' => '余额',
                'ratio' => '利率',
                'created_at' => '创建时间',
            ],
        ]));
    }

    public function testAdminSalesmanOrderIndex()
    {
        $this->adminLogin();

        Config::updateOrCreateByDto(new SalesmanDto([
            'enable' => true,
            'open' => true,
            'rules' => '',
            'ratio' => '20',
        ]));

        // 分销员与客户
        $salesman = MemberFactory::createByData()->setSalesman();
        $custom = MemberFactory::createByData([
            'share_openid' => $salesman->code,
        ]);

        // 套餐
        $package = PackageFactory::createByData();
        // 订单
        $order = OrderFactory::createByData([
            'user_id' => $custom->id,
            'package_id' => $package->id,
        ]);

        $order->paid($order->price);

        $response = $this->get('/admin/salesman/order', [
            'status' => '',
            'created_at' => '',
        ]);

        PackageFactory::truncate();
        MemberFactory::truncate();
        OrderFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '订单列表',
            'category' => '分销管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'mobile' => '',
                'nickname' => '',
            ],
            'request_except' => [],
            'response' => [
                '*.id' => '分销订单ID',
                '*.type' => BaseDto::mapDesc('订单类型', SalesmanOrder::TYPE),
                '*.order_id' => '订单ID',
                '*.trade_no' => '订单编号',
                '*.ratio' => '佣金比例',
                '*.order_price' => '订单金额',
                '*.price' => '佣金',
                '*.status' => BaseDto::mapDesc('状态', SalesmanOrder::STATUS),

                '*.user' => '分销员',
                '*.user.id' => '用户ID',
                '*.user.nickname' => '用户名称',
                '*.user.mobile' => '用户手机号',

                '*.custom' => '客户',
                '*.custom.id' => '客户ID',
                '*.custom.nickname' => '客户名称',
                '*.custom.mobile' => '客户手机号',
            ],
        ]));
    }

}
