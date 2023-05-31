<?php

namespace App\Model\Repository;

use App\Http\Dto\MemberDto;
use App\Job\UserRegisterRecordJob;
use App\Model\Member;

trait MemberTrait
{
    /**
     * @param MemberDto $dto
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|Member
     */
    public static function createByDto(MemberDto $dto)
    {
        $member = Member::query()->create($dto->getData());

        if ($dto->share_openid) {
            // 如果存在分享 share_openid 需要触发
            asyncQueue(new UserRegisterRecordJob($member->id, $dto->share_openid));
        }

        return $member;
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

    /**
     * 修改密码
     *
     * @param $password
     * @return void
     */
    public function changePassword($password)
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
