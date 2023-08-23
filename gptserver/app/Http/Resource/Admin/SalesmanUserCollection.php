<?php

namespace App\Http\Resource\Admin;

use App\Http\Dto\Config\SalesmanDto;
use App\Model\Config;
use App\Model\Member;
use Cblink\HyperfExt\BaseCollection;

class SalesmanUserCollection extends BaseCollection
{

    public function toArray(): array
    {
        /* @var SalesmanDto $config */
        $config = Config::toDto(Config::SALESMAN);

        return $this->resource->map(function (Member $member) use ($config){
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
                'ratio' => ($member->ratio == -1 ? $config->ratio : $member->ratio),
                'created_at' => $member->created_at->toDatetimeString(),
            ];
        })->toArray();
    }

}
