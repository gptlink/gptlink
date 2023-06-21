<?php

namespace App\Http\Control\Salesman;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\WithdrawalDto;
use App\Http\Request\Salesman\WithdrawalApplyRequest;
use App\Http\Resource\Salesman\withdrawalCollection;
use App\Model\Member;
use App\Model\Withdraw;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;

class WithdrawalController extends BaseController
{
    /**
     * 提现记录
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $withdrawal = Withdraw::query()
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->page();

        return new withdrawalCollection($withdrawal);
    }

    /**
     * 获取上一次填写的账号
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function lastAccount()
    {
        $withdrawal = Withdraw::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        return $this->success([
            'channel' => $withdrawal ? $withdrawal->channel : Withdraw::CHANNEL_ALIPAY,
            'config' => $withdrawal ? $withdrawal->config : [],
        ]);
    }

    /**
     * 申请提现
     *
     * @param WithdrawalApplyRequest $request
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function apply(WithdrawalApplyRequest $request)
    {
        /* @var Member $member */
        $member = Member::query()
            ->where('id', auth()->id())
            ->firstOrFail();

        throw_if(
            $member->balance < $request->input('price'),
            LogicException::class,
            ErrCode::SALESMAN_INSUFFICIENT_BALANCE
        );

        $member->applyWithdrawal(new WithdrawalDto($request->validated()));

        return $this->success();
    }
}
