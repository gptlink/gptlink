<?php

namespace App\Http\Dto;

use App\Model\Order;
use Cblink\Dto\Dto;
use Hyperf\Snowflake\IdGeneratorInterface;

class OrderDto extends Dto
{
    protected $fillable = [
        'trade_no',
        'user_id',
        'price',
        'package_id',
        'package_name',
        'pay_type',
        'channel',
        'payload',
    ];

    public function toData()
    {
        return [
            'trade_no' => $this->getItem('trade_no'),
            'user_id' => $this->getItem('user_id'),
            'price' => $this->getItem('price'),
            'package_id' => $this->getItem('package_id'),
            'package_name' => $this->getItem('package_name'),
            'pay_type' => $this->getItem('pay_type'),
            'channel' => $this->getItem('channel'),
            'payload' => $this->getItem('payload'),
            'status' => Order::STATUS_UNPAID,
            'platform' => Order::PLATFORM_GPT,
        ];
    }

    /**
     * @return int
     */
    public static function generate()
    {
        return make(IdGeneratorInterface::class)->generate();
    }
}
