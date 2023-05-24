<?php

namespace App\Model\Repository;

use App\Http\Dto\MemberDto;
use App\Model\Member;

trait MemberTrait
{
    /**
     * @param MemberDto $dto
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|Member
     */
    public static function createByDto(MemberDto $dto)
    {
        return Member::query()->create($dto->getData());
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
}
