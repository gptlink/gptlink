<?php

namespace HyperfTest\Factory;

use App\Http\Dto\WithdrawalDto;
use App\Model\Member;
use App\Model\Withdraw;

class WithdrawalFactory
{

    /**
     * @param Member $member
     * @param array $payload
     * @return void
     */
    public static function create(Member $member, array $payload = [])
    {
        $member->applyWithdrawal(new WithdrawalDto(array_merge([
            'price' => mt_rand(0, 10),
            'channel' => Withdraw::CHANNEL_ALIPAY,
            'config' => [
                'account' => '13100010002',
                'name' => 'text',
            ],
        ], $payload)));
    }

}
