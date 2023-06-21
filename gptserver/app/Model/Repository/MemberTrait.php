<?php

namespace App\Model\Repository;

use App\Http\Dto\MemberDto;
use App\Http\Dto\WithdrawalDto;
use App\Job\UserRegisterRecordJob;
use App\Model\Member;
use App\Model\Withdraw;

trait MemberTrait
{
    /**
     * @param MemberDto $dto
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|Member
     */
    public static function createByDto(MemberDto $dto)
    {
        $member = Member::query()->create($dto->getData());

        // 如果存在分享 share_openid 需要触发
        asyncQueue(new UserRegisterRecordJob($member->id, $dto->share_openid));

        return $member;
    }

    /**
     * 申请提现
     *
     * @param WithdrawalDto $dto
     * @return void
     */
    public function applyWithdrawal(WithdrawalDto $dto)
    {
        $this->decrement('balance', $dto->price);

        Withdraw::query()->create($dto->toModel($this->id));
    }

    /**
     * 设置分销员
     *
     * @return Member
     */
    public function setSalesman()
    {
        $this->identity = Member::IDENTITY_SALESMAN;
        $this->save();

        return $this;
    }

    /**
     * 登陆信息
     *
     * @return array
     */
    public function getLoginInfo()
    {
        return [
            'user' => [
                'openid' => $this->code,
                'nickname' => $this->nickname,
                'avatar' => $this->avatar,
                'status' => $this->status,
                'identity' => $this->identity,
            ],
            'token_type' => 'Bearer',
            'access_token' => auth('user')->login($this),
            'expire_in' => config('auth.guards.user.ttl'),
        ];
    }

    /**
     * 修改状态
     *
     * @param $status
     * @return Member
     */
    public function updateStatus($status)
    {
        $this->update(['status' => $status]);
        return $this->refresh();
    }

    /**
     * 修改密码
     *
     * @param string $password
     * @return void
     */
    public function changePassword(string $password)
    {
        $this->password = sha1($password);
        $this->save();
    }

    /**
     * 验证密码
     *
     * @param $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return $this->password == sha1($password);
    }
}
