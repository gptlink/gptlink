<?php

namespace App\Http\Resource;

use App\Http\Service\WechatPayService;
use App\Model\Order;
use Cblink\HyperfExt\BaseResource;

/**
 * @property Order $resource
 */
class OrderPayResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'package_name' => $this->resource->package_name,
            'price' => $this->resource->price,
            'channel' => $this->resource->channel,
            'pay_type' => $this->resource->pay_type,
            'data' => $this->getData($this->resource->pay_type),
        ];
    }

    public function getData($payType)
    {
        if ($this->resource->channel == Order::CHANNEL_WECHAT) {
            $service = app()->get(WechatPayService::class);

            // 小程序/微信内置打开
            if ($payType == Order::PAY_JSAPI) {
                return $service->pay()->jssdk->bridgeConfig($this->resource->payload['prepay_id'], false);
            }

            // pc 扫码
            if ($payType == Order::PAY_NATIVE) {
                return [
                    'code_url' => $this->resource->payload['code_url'],
                ];
            }
        }

        return [];
    }
}
