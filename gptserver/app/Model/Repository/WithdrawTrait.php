<?php

namespace App\Model\Repository;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Model\Member;
use App\Model\Withdraw;

trait WithdrawTrait
{

    /**
     * 拒绝提现
     *
     * @param string $reason 拒绝原因
     * @return void
     * @throws \Throwable
     */
    public function refuse(string $reason)
    {
        throw_unless(
            in_array($this->status, [Withdraw::STATUS_PADDING, Withdraw::STATUS_SUCCESS]),
            LogicException::class,
            ErrCode::ADMIN_WITHDRAW_STATUS_FAIL
        );

        $this->reason = $reason;
        $this->status = Withdraw::STATUS_REFUSE;

        Member::query()
            ->where('id', $this->member_id)
            ->increment('balance', $this->price);
    }

    /**
     *  同意提现
     *
     * @return void
     * @throws \Throwable
     */
    public function agree()
    {
        throw_unless(
            in_array($this->status, [Withdraw::STATUS_PADDING]),
            LogicException::class,
            ErrCode::ADMIN_WITHDRAW_STATUS_FAIL
        );

        $this->status = Withdraw::STATUS_SUCCESS;
        $this->save();
    }

    /**
     * 转账
     *
     * @param $paid
     * @return void
     * @throws \Throwable
     */
    public function transfer($paid)
    {
        throw_unless(
            in_array($this->status, [Withdraw::STATUS_SUCCESS]),
            LogicException::class,
            ErrCode::ADMIN_WITHDRAW_STATUS_FAIL
        );

        $this->paid_no = $paid;
        $this->status = Withdraw::STATUS_TRANSFER;
        $this->save();
    }
}
