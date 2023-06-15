<?php

namespace App\Http\Service;

use App\Http\Dto\Config\WechatPaymentDto;
use App\Http\Dto\PayOrderDto;
use App\Model\Config;
use App\Model\Order;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;

class PaymentService
{
    /**
     * @var WechatPayService
     */
    protected $wechat;

    public function __construct(WechatPayService $service)
    {
        $this->wechat = $service;
    }

    /**
     * 用户下单
     *
     * @param PayOrderDto $dto
     * @return mixed
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    public function unify(PayOrderDto $dto)
    {
        $response = $this->wechat->v2Order($dto->toData());

        return $this->wechat->response($response);
    }
}
