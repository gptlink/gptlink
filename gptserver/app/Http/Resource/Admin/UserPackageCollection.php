<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\MemberPackage;
use Cblink\HyperfExt\BaseCollection;

class UserPackageCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (MemberPackage $memberPackage) {
            return [
                'id' => $memberPackage->id,
                'name' => $memberPackage->name,
                'user_id' => $memberPackage->user_id,
                'channel' => $memberPackage->channel,
                'type' => $memberPackage->type,
                'num' => $memberPackage->num,
                'used' => $memberPackage->used,
                'expired_at' => $memberPackage->expired_at,
                'created_at' => $memberPackage->created_at,
            ];
        })->toArray();
    }
}
