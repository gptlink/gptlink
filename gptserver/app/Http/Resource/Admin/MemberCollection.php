<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\Member;
use Cblink\HyperfExt\BaseCollection;

class MemberCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (Member $member) {
            return [
                'id' => $member->id,
                'nickname' => $member->nickname,
                'mobile' => $member->mobile,
                'avatar' => $member->avatar,
                'status' => $member->status,
                'platform' => $member->platform,
                'business_id' => $member->business_id,
                'source' => $member->source,
                'register_at' => $member->created_at->toDateTimeString(),
            ];
        })->toArray();
    }
}
