<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\MemberOauth;
use Cblink\HyperfExt\BaseCollection;

class MemberOauthCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (MemberOauth $memberOauth) {
            return [
                'id' => $memberOauth->id,
                'member_id' => $memberOauth->member_id,
                'nickname' => $memberOauth->nickname,
                'avatar' => $memberOauth->avatar,
                'unionid' => $memberOauth->unionid,
                'openid' => $memberOauth->openid,
                'platform' => $memberOauth->platform,
                'appid' => $memberOauth->appid,
            ];
        })->toArray();
    }
}
