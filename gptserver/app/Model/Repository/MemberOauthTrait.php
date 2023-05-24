<?php

namespace App\Model\Repository;

use App\Http\Dto\OauthDto;
use App\Model\MemberOauth;

trait MemberOauthTrait
{
    /**
     * @param OauthDto $dto
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function findOrcreateByDto(OauthDto $dto)
    {
        $oauth = MemberOauth::query()->where([
            'platform' => $dto->platform,
            'openid' => $dto->openid,
        ])->first();

        if (! $oauth) {
            $oauth = MemberOauth::query()->create($dto->getOauthData());
        }

        return $oauth;
    }

    /**
     * 修改用户 id
     *
     * @param int $memberId
     * @return MemberOauth
     */
    public function updateMemberId(int $memberId)
    {
        $this->update(['member_id' => $memberId]);
        return $this->refresh();
    }
}
