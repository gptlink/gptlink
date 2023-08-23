<?php

namespace App\Http\Resource;

use App\Model\Member;
use Cblink\HyperfExt\BaseResource;

/**
 * @property Member $resource
 */
class MemberResource extends BaseResource
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'openid' => $this->resource->code,
            'nickname' => $this->resource->nickname,
            'avatar' => $this->resource->avatar,
            'status' => $this->resource->status,
            'identity' => $this->resource->identity,
        ];
    }


}
