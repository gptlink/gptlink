<?php

namespace Api\Admin;

use App\Model\Task;
use App\Model\Withdraw;
use HyperfTest\Factory\MemberFactory;
use HyperfTest\Factory\WithdrawalFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class WithdrawTest extends TestCase
{
    use LoginTrait;

    public function testAdminWithdrawIndex()
    {
        $this->adminLogin();

        $member = MemberFactory::createByData();
        WithdrawalFactory::create($member);

        $response = $this->get('/admin/salesman/withdraw', [
            'channel' => '',
            'status' => '',
        ]);

        MemberFactory::truncate();
        WithdrawalFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '提现列表',
            'category' => '分佣管理',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => 'id',
                '*.serial_no' => '提现流水号',
                '*.price' => '提现金额',
                '*.channel' => '提现渠道',
                '*.config' => '配置',
                '*.status' => BaseDto::mapDesc('状态', Withdraw::STATUS),
                '*.paid_no' => '支付号',
                '*.user_id' => '用户ID',
                '*.created_at' => '申请时间',
            ],
        ]));
    }

    public function testAdminWithdrawAgree()
    {
        $this->adminLogin();

        $member = MemberFactory::createByData();
        $withdraw = WithdrawalFactory::create($member);

        $response = $this->post(sprintf('/admin/salesman/withdraw/%s/agree', $withdraw->id));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '提现 - 同意提现',
            'category' => '分佣管理',
            'params' => [
                4 => '提现ID',
            ],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [],
        ]));
    }

    public function testAdminWithdrawalRefuse()
    {
        $this->adminLogin();

        $member = MemberFactory::createByData();
        $withdraw = WithdrawalFactory::create($member);

        $response = $this->post(sprintf('/admin/salesman/withdraw/%s/refuse', $withdraw->id), [
            'reason' => '不允许提现',
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '提现 - 拒绝提现',
            'category' => '分佣管理',
            'params' => [
                4 => '提现ID',
            ],
            'desc' => '',
            'request' => [
                'reason' => '拒绝理由',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

    public function testAdminWithdrawTransfer()
    {
        $this->adminLogin();

        $member = MemberFactory::createByData();
        $withdraw = WithdrawalFactory::create($member);
        $withdraw->agree();

        $response = $this->post(sprintf('/admin/salesman/withdraw/%s/transfer', $withdraw->id), [
            'paid_no' => '123123435346465',
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '提现 - 确认转账',
            'category' => '分佣管理',
            'params' => [
                4 => '提现ID',
            ],
            'desc' => '',
            'request' => [
                'paid_no' => '支付流水号',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

}
