<?php

namespace App\Http\Control\Web;

use App\Base\WechatServiceProvider;
use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\OrderDto;
use App\Http\Dto\PayOrderDto;
use App\Http\Request\Web\OrderRequest;
use App\Http\Resource\OrderPayResource;
use App\Http\Resource\OrderResource;
use App\Http\Service\PaymentService;
use App\Model\Config;
use App\Model\MemberOauth;
use App\Model\Order;
use App\Model\Package;
use Carbon\Carbon;
use Cblink\HyperfExt\BaseController;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class OrderController extends BaseController
{
    /**
     * 下订单
     *
     * @param OrderRequest $request
     * @param PaymentService $service
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     * @throws \Throwable
     */
    public function create(OrderRequest $request, PaymentService $service)
    {
        $package = Package::query()->where('show', Package::SHOW_ON)->find($request->input('package_id'));

        throw_unless($package, LogicException::class, ErrCode::PACKAGE_IS_OFFLINE);

        // 查询近30分钟没支付的订单，如果有就不重复拉起支付
        $order = Order::query()
            ->where([
                'package_id' => $package->id,
                'pay_type' => $request->input('pay_type'),
                'channel' => $request->input('channel'),
                'status' => Order::STATUS_UNPAID,
                'user_id' => auth()->id(),
                'price' => $package->price,
            ])
            ->where('created_at', '>=', Carbon::now()->subMinutes(30)->toDateTimeString())
            ->first();

        if (! $order) {
            $payUserId = $request->input('user_id');

            if (! $payUserId && $request->input('pay_type') == Order::PAY_JSAPI) {
                $oauth = MemberOauth::query()->where([
                    'member_id' => auth()->id(),
                    'platform' => strtolower(WechatServiceProvider::IDENTIFIER),
                    'appid' => Config::toDto(Config::WECHAT_PLATFORM)->client_id,
                ])->first();

                if ($oauth) {
                    $payUserId = base64_encode($oauth->openid);
                }
            }

            $payDto = new PayOrderDto([
                'pay_type' => $request->input('pay_type'),
                'channel' => $request->input('channel'),
                'price' => $package->price,
                'body' => sprintf('购买套餐 %s', $package->name),
                'trade_type' => $request->input('pay_type'),
                'user_id' => $payUserId,
                'trade_no' => $tradeNo = OrderDto::generate(),
            ]);

            $response = $service->unify($payDto);

            $order = Order::createByDto(new OrderDto(array_filter([
                'trade_no' => $tradeNo,
                'user_id' => auth()->id(),
                'price' => $package->price,
                'package_id' => $package->id,
                'package_name' => $package->name,
                'pay_type' => $request->input('pay_type'),
                'channel' => $request->input('channel'),
                'payload' => $response,
            ])));
        }

        return new OrderResource($order);
    }

    /**
     * 获取支付参数
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function pay($id)
    {
        $order = Order::query()->where([
            'id' => $id,
            'user_id' => auth()->id(),
        ])->firstOrFail();

        return new OrderPayResource($order);
    }

    /**
     * 查询支付状态
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show($id)
    {
        $order = Order::query()->where([
            'id' => $id,
            'user_id' => auth()->id(),
        ])->firstOrFail(['id', 'trade_no', 'user_id', 'status']);

        return $this->success($order->toArray());
    }
}
