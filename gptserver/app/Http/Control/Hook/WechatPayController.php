<?php

namespace App\Http\Control\Hook;

use App\Http\Service\WechatPayService;
use App\Model\Order;
use Cblink\HyperfExt\BaseController;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use Hyperf\HttpServer\Contract\RequestInterface;
use Symfony\Component\HttpFoundation\Response;

class WechatPayController extends BaseController
{
    /**
     * 微信支付的回调处理
     *
     * @param RequestInterface $request
     * @param WechatPayService $service
     * @param mixed $orderNo
     * @return Response
     * @throws InvalidArgumentException
     */
    public function hook(RequestInterface $request, WechatPayService $service, $orderNo)
    {
        return $service->handlePaidNotify(function ($message, $fail) use ($orderNo) {
            logger()->info('接受支付回调', $message);

            $order = Order::query()->where('trade_no', $orderNo)->first();

            if ($order->isPaid()) {
                return true;
            }

            // 完成支付
            $order->paid(bcdiv((string) $message['total_fee'], '100', 2), $message['transaction_id']);

            return true;
        }, $request);
    }
}
