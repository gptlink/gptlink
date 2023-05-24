<?php

namespace HyperfTest\Api;

use App\Model\ChatGptModelCount;
use App\Model\MemberPackage;
use App\Model\Order;
use App\Model\Package;
use Cblink\Hyperf\Yapi\Dto;
use HyperfTest\Factory\ChatGptModelFactory;
use HyperfTest\Factory\MemberFactory;
use HyperfTest\Factory\MemberPackageFactory;
use HyperfTest\Factory\OrderFactory;
use HyperfTest\Factory\PackageFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends TestCase
{
    use LoginTrait;

    public function testWebGetUserProfile()
    {
        $user = $this->userLogin();

        MemberFactory::createByData([
            'user_id' => $user['user_id'],
        ]);

        $response = $this->get('/user/profile');

        $response->dump();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '获取用户资料',
            'category' => '用户相关',
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'openid' => '用户的openid, 非微信openid',
                'nickname' => '用户名',
                'avatar' => '用户头像',
                'identity' => BaseDto::mapDesc('身份标识，一个用户会有多个身份', Package::IDENTITY),
            ],
        ]));
    }

    public function testWebUserBillPackage()
    {
        $user = $this->userLogin();
        $memberPackage = MemberPackageFactory::createByData(['user_id' => $user['user_id']]);

        $response = $this->get('/user/bill-package', [
            'status' => '',
            'channel' => '',
            'type' => '',
        ]);
        $memberPackage->delete();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '用户计费套餐',
            'category' => '用户相关',
            'desc' => '',
            'request' => [
                'status' => Dto::mapDesc('状态筛选', MemberPackage::STATUS),
                'channel' => Dto::mapDesc('渠道筛选', MemberPackage::CHANNEL),
                'type' => Dto::mapDesc('类型筛选', Package::TYPE),
            ],
            'request_except' => ['status', 'channel', 'type'],
            'response' => [
                'id' => 'id',
                'status' => Dto::mapDesc('状态:', MemberPackage::STATUS),
                'channel' => Dto::mapDesc('渠道:', MemberPackage::CHANNEL),
                'type' => Dto::mapDesc('类型:', Package::TYPE),
                'num' => '套餐内次数，如果为-1则表示不限制',
                'used' => '使用量',
                'expired_at' => '有效期，如果为空则表示不失效',
            ],
        ]));
    }

    public function testWebUserPackage()
    {
        $user = $this->userLogin();
        $memberPackage = MemberPackageFactory::createByData(['user_id' => $user['user_id']]);

        $response = $this->get('/user/package', [
            'status' => '',
            'channel' => '',
            'type' => '',
        ]);
        $memberPackage->delete();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '用户套餐',
            'category' => '用户相关',
            'desc' => '',
            'request' => [
                'status' => Dto::mapDesc('状态筛选', MemberPackage::STATUS),
                'channel' => Dto::mapDesc('渠道筛选', MemberPackage::CHANNEL),
                'type' => Dto::mapDesc('类型筛选', Package::TYPE),
            ],
            'request_except' => ['status', 'channel', 'type'],
            'response' => [
                '*.id' => 'id',
                '*.status' => Dto::mapDesc('状态:', MemberPackage::STATUS),
                '*.channel' => Dto::mapDesc('渠道:', MemberPackage::CHANNEL),
                '*.type' => Dto::mapDesc('类型:', Package::TYPE),
                '*.num' => '套餐内次数，如果为-1则表示不限制',
                '*.used' => '使用量',
                '*.expired_at' => '有效期，如果为空则表示不失效',
            ],
        ]));
    }

    public function testWebUserOrder()
    {
        $user = $this->userLogin();
        $order = OrderFactory::createByData(['user_id' => $user['user_id']]);
        $response = $this->get('/user/order');
        $this->assertApiSuccess($response);
        $order->delete();
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '用户订单',
            'category' => '用户相关',
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => 'id',
                '*.trade_no' => '订单编号',
                '*.user_id' => '用户 id',
                '*.channel' => Dto::mapDesc('渠道:', Order::CHANNEL),
                '*.pay_type' => Dto::mapDesc('支付类型:', Order::PAY_TYPE),
                '*.payload' => '支付参数',
                '*.price' => '金额',
                '*.payment' => '实际支付金额',
                '*.status' => Dto::mapDesc('支付类型:', Order::STATUS),
                '*.package_id' => '套餐 id',
                '*.package_name' => '套餐名称',
            ],
        ]));
    }

    public function testWebUserGetPackageRecord()
    {
        $user = $this->userLogin();
        PackageFactory::createByData()->sendToUser($user['user_id']);
        $response = $this->get('/user/package/record', [
            'type' => '',
            'channel' => '',
        ]);

        $this->assertApiSuccess($response);
        PackageFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '获取用户套餐记录',
            'category' => '用户相关',
            'desc' => '',
            'request' => [
                'type' => BaseDto::mapDesc('套餐类型', Package::TYPE),
                'channel' => BaseDto::mapDesc('获取渠道筛选', MemberPackage::CHANNEL),
            ],
            'request_except' => [],
            'response' => [
                '*.id' => '记录ID',
                '*.user_id' => '用户ID',
                '*.package_id' => '套餐ID',
                '*.package_name' => '套餐名称（历史）',
                '*.channel' => BaseDto::mapDesc('渠道筛选', MemberPackage::CHANNEL),
                '*.type' => BaseDto::mapDesc('类型', Package::TYPE),
                '*.code' => '套餐标识',
                '*.expired_day' => '有效期，单位天',
                '*.num' => '数量，-1表示不限制',
                '*.created_at' => '创建时间',
            ],
        ]));
    }

    public function testUserGetStatistics()
    {
        $user = $this->userLogin();

        $chatGptModel = ChatGptModelFactory::createByData(['user_id' => $user['id']]);
        ChatGptModelFactory::createCollect($user['id'], $chatGptModel->id);
        ChatGptModelCount::query()->where(['chat_gpt_model_id' => $chatGptModel->id])->update(['uses'=>10]);

        $response = $this->get('/user/statistics');
        $response->dump();
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '用户基础统计',
            'category' => '用户相关',
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'model_count' => '我的创作统计',
                'model_collect_count' => '咒语书统计',
                'uses' => '被使用次数'
            ],
        ]));
    }
}
