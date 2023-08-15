<?php

namespace App\Http\Resource\Admin;

use App\Model\Member;
use Cblink\HyperfExt\BaseCollection;

class SalesmanUserCollection extends BaseCollection
{

    public function toArray(): array
    {
        return $this->resource->map(function (Member $member) {
            return [
                'id' => $member->id,
                'nickname' => $member->nickname,
                'avatar' => $member->avatar,
                'mobile' => $member->mobile,
                'status' => $member->status,
                'platform' => $member->platform,
                'source' => $member->source,
                'account_type' => $member->account_type,
                'balance' => $member->balance,
                'ratio' => $member->ratio,
                'created_at' => $member->created_at->toDatetimeString(),
            ];
        })->toArray();
    }

}
