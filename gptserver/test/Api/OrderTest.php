<?php

namespace HyperfTest\Api;

use App\Model\Order;
use Cblink\Hyperf\Yapi\Dto;
use HyperfTest\Factory\OrderFactory;
use HyperfTest\Factory\PackageFactory;
use HyperfTest\LoginTrait;
use HyperfTest\Mock\WechatPayServiceMock;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class OrderTest extends TestCase
{
    use LoginTrait;

    public function testCreateOrder()
    {
        $user = $this->userLogin();

        WechatPayServiceMock::mock();

        $package = PackageFactory::createByData();

        $response = $this->post('/order', [
            'package_id' => $package->id,
            'channel' => Order::CHANNEL_WECHAT,
            'pay_type' => Order::PAY_JSAPI,
            'user_id' => '',
            'status' => '',
            'platform' => '',
            'business_id' => 0,
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '创建订单',
            'category' => '订单相关',
            'params' => [
                2 => '订单ID',
            ],
            'desc' => '',
            'request' => [
                'package_id' => '套餐ID',
                'channel' => BaseDto::mapDesc('支付渠道', Order::CHANNEL),
                'pay_type' => BaseDto::mapDesc('支付类型', Order::PAY_TYPE),
                'user_id' => 'JSAPI 类型必传，如果为支付宝内打开传入支付宝user_id，如果为微信内打开传入微信openid',
                'status' => BaseDto::mapDesc('订单状态', Order::STATUS),
                'platform' => BaseDto::mapDesc('订单来源平台', Order::PLATFORM),
                'business_id' => 'gptlink商户ID 或 aiyaaa的模型ID',
            ],
            'request_except' => ['business_id', 'platform'],
            'response' => [
                'id' => '订单ID',
                'trade_no' => '订单编号',
                'channel' => BaseDto::mapDesc('支付渠道', Order::CHANNEL),
                'pay_type' => BaseDto::mapDesc('支付类型', Order::PAY_TYPE),
                'price' => '价格',
                'status' => '状态',
                'package_id' => '套餐ID',
                'package_name' => '套餐名称',
                'created_at' => '创建时间',
                'platform' => BaseDto::mapDesc('订单来源平台', Order::PLATFORM),
                'business_id' => 'gptlink商户ID 或 aiyaaa的模型ID',
            ],
        ]));

        PackageFactory::truncate();
    }

    public function testWebGetOrderPay()
    {
        $user = $this->userLogin();

        $order = OrderFactory::createByData(['user_id' => $user['user_id']]);

        $response = $this->get(sprintf('/order/%s/pay', $order->id));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '获取订单支付参数',
            'category' => '订单相关',
            'desc' => 'data 返回说明<br/><br/>如果pay_type 为 JSAPI，返回字段为 appId， timeStamp，nonceStr，package，signType  用于在微信环境内拉起微信支付<br/><br/><br/>如果pay_type 为 NATIVE，返回字段为 code_url ，前端同学需要将 code_url 内容生成二维码用于支付扫码',
            'params' => [
                2 => '订单ID',
            ],
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => '订单ID',
                'package_name' => '套餐名称',
                'price' => '订单价格',
                'channel' => Dto::mapDesc('渠道', Order::CHANNEL),
                'pay_type' => Dto::mapDesc('支付类型', Order::PAY_TYPE),
                'data' => '返回的支付要素，详见接口说明',
            ],
        ]));
    }

    public function testGetWebOrder()
    {
        $user = $this->userLogin();

        $order = OrderFactory::createByData(['user_id' => $user['user_id']]);

        $response = $this->get(sprintf('/order/%s', $order->id));

        $this->assertApiSuccess($response);
        $order->delete();
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '获取订单支付状态',
            'category' => '订单相关',
            'params' => [
                2 => '订单ID',
            ],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'trade_no' => '订单编号',
                'user_id' => '用户id',
                'status' => Dto::mapDesc('状态:', Order::STATUS),
            ],
        ]));
    }
}
