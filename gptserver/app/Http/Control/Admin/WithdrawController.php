<?php

namespace App\Http\Control\Admin;

use App\Http\Dto\WithdrawTransferDto;
use App\Http\Request\Admin\WithdrawAgreeRequest;
use App\Http\Request\Admin\WithdrawRefuseRequest;
use App\Http\Resource\Admin\WithdrawCollection;
use App\Model\Withdraw;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;

class WithdrawController extends BaseController
{
    /**
     * 提现列表
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $withdraw = Withdraw::query()
            ->search([
                'channel' => ['type' => 'eq'],
                'status' => ['type' => 'eq'],
            ])
            ->latest()
            ->page();

        return new WithdrawCollection($withdraw);
    }

    /**
     * 拒绝提现
     *
     * @param WithdrawRefuseRequest $request
     * @param $id
     * @return ResponseInterface
     */
    public function refuse(WithdrawRefuseRequest $request, $id)
    {
        $withdraw = Withdraw::query()->findOrFail($id);

        $withdraw->refuse($request->input('reason'));

        return $this->success();
    }

    /**
     * 通过提现
     *
     * @param $id
     * @return ResponseInterface
     */
    public function agree($id)
    {
        $withdraw = Withdraw::query()->findOrFail($id);

        $withdraw->agree();

        return $this->success();
    }

    /**
     * 提现转账
     *
     * @param WithdrawAgreeRequest $request
     * @param $id
     * @return ResponseInterface
     */
    public function transfer(WithdrawAgreeRequest $request, $id)
    {
        $withdraw = Withdraw::query()->findOrFail($id);

        $withdraw->transfer($request->input('paid_no'));

        return $this->success();
    }
}
