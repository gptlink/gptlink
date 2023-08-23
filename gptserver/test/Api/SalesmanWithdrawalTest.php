<?php

namespace Api;

use App\Model\Withdraw;
use HyperfTest\Factory\MemberFactory;
use HyperfTest\Factory\WithdrawalFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class SalesmanWithdrawalTest extends TestCase
{
    use LoginTrait;

    public function testWithdrawalIndex()
    {
        $member = $this->userLogin()->setSalesman();

        WithdrawalFactory::create($member);

        $response = $this->get('/salesman/withdrawal', [
            'page' => 1,
            'per_page' => 15,
        ]);

        MemberFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '提现列表',
            'category' => '分销相关',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => '提现记录ID',
                '*.serial_no' => '流水号',
                '*.price' => '提现金额',
                '*.status' => BaseDto::mapDesc('提现状态', Withdraw::STATUS),
                '*.paid_no' => '转账单号',
                '*.user_id' => '用户ID',
                '*.created_at' => '申请时间',
            ],
        ]));
    }

    public function testWithdrawalLast()
    {
        $member = $this->userLogin()->setSalesman();

        WithdrawalFactory::create($member);

        $response = $this->get('/salesman/withdrawal/last');

        MemberFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '获取上次提现配置',
            'category' => '分销相关',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'channel' => BaseDto::mapDesc('渠道', Withdraw::CHANNEL),
                'config' => '配置项',
                'config.name' => '真实名称',
                'config.account' => '支付宝账号',
            ],
        ]));
    }

    public function testWithdrawalApply()
    {
        $member = $this->userLogin()->setSalesman();

        WithdrawalFactory::create($member);

        $member->increment('balance', 10000);

        $response = $this->post('/salesman/withdrawal/apply', [
            'price' => mt_rand(0, 10),
            'channel' => Withdraw::CHANNEL_ALIPAY,
            'config' => [
                'account' => '13100010002',
                'name' => 'text',
            ],
        ]);

        $this->assertApiSuccess($response);

        MemberFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '申请提现',
            'category' => '分销相关',
            'params' => [],
            'desc' => '',
            'request' => [
                'channel' => BaseDto::mapDesc('渠道', Withdraw::CHANNEL),
                'config' => '配置项',
                'config.name' => '真实名称',
                'config.account' => '支付宝账号',
                'price' => '提现金额',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }
}
