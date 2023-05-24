<?php

namespace App\Http\Dto;

use App\Model\Order;
use Cblink\HyperfExt\Dto;

/**
 * @property string $channel 支付渠道
 * @property string $trade_type JSAPI或网站应用
 */
class PayOrderDto extends Dto
{
    protected $fillable = [
        'pay_type', 'channel', 'price', 'body', 'trade_type', 'user_id', 'trade_no',
    ];

    public function toData()
    {
        // 微信参数
        if ($this->getItem('channel') == Order::CHANNEL_WECHAT) {
            $item = [
                'body' => $this->getItem('body'),
                'trade_type' => $this->getItem('pay_type'),
                'out_trade_no' => $this->getItem('trade_no'),
                'total_fee' => bcmul((string) $this->getItem('price'), '100'),
                'spbill_create_ip' => '127.0.0.1',
                'notify_url' => url(sprintf('/hook/%s/paid', $this->getItem('trade_no'))),
            ];

            if ($this->getItem('user_id')) {
                $item['openid'] = $this->getUserId();
            }

            return $item;
        }

        // 支付宝参数
        if ($this->getItem('channel') == Order::CHANNEL_ALIPAY) {
            return [];
        }

        return [];
    }

    /**
     * @return false|string
     */
    public function getUserId()
    {
        return base64_decode($this->getItem('user_id'));
    }
}
