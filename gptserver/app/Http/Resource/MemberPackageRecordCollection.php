<?php

namespace App\Http\Resource;

use App\Model\MemberPackageRecord;
use Cblink\HyperfExt\BaseCollection;

class MemberPackageRecordCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (MemberPackageRecord $record) {
            return [
                'id' => $record->id,
                'user_id' => $record->user_id,
                'package_id' => $record->package_id,
                'package_name' => $record->package_name,
                'channel' => $record->channel,
                'type' => $record->channel,
                'code' => $record->code,
                'expired_day' => $record->expired_day,
                'num' => $record->num,
                'created_at' => $record->created_at,
            ];
        })->toArray();
    }
}
