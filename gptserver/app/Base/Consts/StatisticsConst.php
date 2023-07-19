<?php

namespace App\Base\Consts;

class StatisticsConst
{
    public const MEMBER_COUNT = 'member_count';

    public const PAYMENT_COUNT = 'payment_count';

    public const STATISTICS_TYPE = [
        self::MEMBER_COUNT => '会员数量',
        self::PAYMENT_COUNT => '支付总金额',
    ];

    public const STATISTICS_METHOD = [
        self::MEMBER_COUNT => 'userCount',
        self::PAYMENT_COUNT => 'paymentCount',
    ];
}
