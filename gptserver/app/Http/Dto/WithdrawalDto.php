<?php

namespace App\Http\Dto;

use App\Model\Withdraw;
use Cblink\HyperfExt\Dto;
use Hyperf\Snowflake\IdGeneratorInterface;

/**
 * @property $price
 */
class WithdrawalDto extends Dto
{
    protected $fillable = [
        'price', 'channel', 'config',
    ];

    public function toModel($userId)
    {
        return [
            'serial_no' => make(IdGeneratorInterface::class)->generate(),
            'price' => $this->getItem('price'),
            'channel' => $this->getItem('channel'),
            'config' => $this->getItem('config', []),
            'status' => Withdraw::STATUS_PADDING,
            'user_id' => $userId,
        ];
    }
}
