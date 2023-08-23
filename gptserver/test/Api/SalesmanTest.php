<?php

namespace Api;

use App\Http\Dto\Config\SalesmanDto;
use App\Http\Dto\SalesmanOrderDto;
use App\Model\Config;
use App\Model\Order;
use App\Model\SalesmanOrder;
use Hyperf\Utils\Str;
use HyperfTest\Factory\MemberFactory;
use HyperfTest\Factory\OrderFactory;
use HyperfTest\Factory\PackageFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class SalesmanTest extends TestCase
{
    use LoginTrait;

    public function testPostMemberSalesman()
    {
        $member = $this->userLogin();

        $response = $this->post('/user/salesman');

        $this->assertApiSuccess($response);

        MemberFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '申请分销员',
            'category' => '分销相关',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [],
        ]));
    }

    public function testSalesmanOrderIndex()
    {
        $member = $this->userLogin()->setSalesman();
        // 创建下级
        $custom = MemberFactory::createByData(['share_openid' => $member->code]);

        // 开启分销
        Config::updateOrCreateByDto(new SalesmanDto([
            'enable' => true,
            'open' => true,
            'rules' => '示例',
            'ratio' => 10,
        ]));

        // 创建订单
        $package = PackageFactory::createByData();
        $order = OrderFactory::createByData(['user_id' => $custom->id, 'package_id' => $package->id]);
        $order->paid($order->price, Str::random());

        $response = $this->get('/salesman/order', [
            'per_page' => 10,
            'page' => 1,
        ]);

        $this->assertApiSuccess($response);

        MemberFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '佣金订单列表',
            'category' => '分销相关',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => '订单ID',
                '*.ratio' => '佣金比例',
                '*.price' => '佣金',
                '*.status' => BaseDto::mapDesc('订单状态', SalesmanOrder::STATUS),
                '*.custom' => '客户信息',
                '*.custom.openid' => 'openid',
                '*.custom.nickname' => '用户名，脱敏后的',
            ],
        ]));
    }

    public function testSalesmanChildIndex()
    {
        $member = $this->userLogin()->setSalesman();
        // 创建下级
        $custom = MemberFactory::createByData(['share_openid' => $member->code]);

        // 开启分销
        Config::updateOrCreateByDto(new SalesmanDto([
            'enable' => true,
            'open' => true,
            'rules' => '示例',
            'ratio' => 10,
        ]));

        // 创建订单
        $package = PackageFactory::createByData();
        $order = OrderFactory::createByData(['user_id' => $custom->id, 'package_id' => $package->id]);
        $order->paid($order->price, Str::random());

        $response = $this->get('/salesman/child', [
            'per_page' => 10,
            'page' => 1,
        ]);

        $this->assertApiSuccess($response);

        MemberFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '客户列表',
            'category' => '分销相关',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.openid' => '客户的openid',
                '*.nickname' => '用户名',
                '*.avatar' => '用户头像',
                '*.order_price' => '合计贡献佣金',
                '*.order_num' => '合计订单数',
                '*.created_at' => '创建时间',
            ],
        ]));
    }

    public function testSalesmanStatistics()
    {
        $member = $this->userLogin()->setSalesman();
        // 创建下级
        $custom = MemberFactory::createByData(['share_openid' => $member->code]);

        // 开启分销
        Config::updateOrCreateByDto(new SalesmanDto([
            'enable' => true,
            'open' => true,
            'rules' => '示例',
            'ratio' => 10,
        ]));

        // 创建订单
        $package = PackageFactory::createByData();
        $order = OrderFactory::createByData(['user_id' => $custom->id, 'package_id' => $package->id]);
        $order->paid($order->price, Str::random());

        $response = $this->get('/salesman/statistics');

        $this->assertApiSuccess($response);

        MemberFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '分销统计',
            'category' => '分销相关',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'order_num' => '总订单数',
                'order_price' => '总佣金',
                'custom_num' => '客户数',
                'balance' => '余额',
                'ratio' => '比例',
            ],
        ]));
    }

    public function testSalesmanBalance()
    {
        $member = $this->userLogin()->setSalesman();

        $response = $this->get('/salesman/balance');

        $this->assertApiSuccess($response);

        MemberFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '佣金余额',
            'category' => '分销相关',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'balance' => '余额',
            ],
        ]));
    }
}
