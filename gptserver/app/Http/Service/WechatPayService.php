<?php

namespace App\Http\Service;

use App\Http\Dto\Config\WechatPaymentDto;
use App\Model\Config;
use Closure;
use App\Exception\WechatPayException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Payment\Application;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Arr;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WechatPayService
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string $appid
     */
    protected $hashed;

    /**
     *  获取支付实例
     *
     * @return Application
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function pay(array $config = [])
    {
        /* @var WechatPaymentDto $payDto */
        $payDto = Config::toDto(Config::WECHAT_PAYMENT);
        $hashed = $this->getHashed($payDto);

        // 如果配置项发生了变更，则重载配置
        if (! $this->app || $hashed != $this->hashed) {
            $this->app = new Application(array_merge($config, [
                'app_id' => $payDto->appid,
                'mch_id' => $payDto->mch_id,
                'key' => $payDto->key,
            ]));
            $this->app->rebind('logger', logger());
            $this->app->rebind('cache', cache());

            $this->hashed = $hashed;
        }

        return $this->app;
    }

    /**
     * @param WechatPaymentDto $payDto
     * @return string
     */
    public function getHashed(WechatPaymentDto $payDto)
    {
        return base64_encode(sprintf('%s%s%s', $payDto->appid, $payDto->mch_id, $payDto->key));
    }

    /**
     * @param $app
     * @param RequestInterface $request
     * @return mixed
     */
    public static function setRequest($app, RequestInterface $request)
    {
        $get = $request->getQueryParams();
        $post = $request->getParsedBody();
        $cookie = $request->getCookieParams();
        $uploadFiles = $request->getUploadedFiles() ?? [];
        $server = $request->getServerParams();
        $xml = $request->getBody()->getContents();

        $files = [];
        /** @var \Hyperf\HttpMessage\Upload\UploadedFile $v */
        foreach ($uploadFiles as $k => $v) {
            $files[$k] = $v->toArray();
        }

        $req = new Request($get, $post, [], $cookie, $files, $server, $xml);
        $req->headers = new HeaderBag($request->getHeaders());
        $app->rebind('request', $req);

        return $app;
    }

    /**
     * 事件回调
     *
     * @param RequestInterface $request
     * @param Closure $closure
     * @return Response
     * @throws InvalidArgumentException
     */
    public function handlePaidNotify(Closure $closure, RequestInterface $request)
    {
        return static::setRequest($this->pay(), $request)->handlePaidNotify($closure);
    }

    /**
     * 下单
     *
     * @param array $data
     * @return mixed
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function v2Order(array $data = [])
    {
        $response = $this->pay()->order->unify($data);

        return $this->response($response);
    }

    /**
     * @param mixed $response
     * @return mixed
     */
    public function response($response)
    {
        $result_code = $response['result_code'] ?? 'SUCCESS';
        $return_code = $response['return_code'] ?? 'SUCCESS';

        // 请求失败，返回错误信息
        if (! ($result_code == 'SUCCESS' && $return_code == 'SUCCESS')) {
            throw new WechatPayException(
                Arr::get($response, 'err_code_des', Arr::get($response, 'return_msg')),
                Arr::get($response, 'result_code', Arr::get($response, 'return_code'))
            );
        }

        return $response;
    }

    /**
     * 查询支付结果
     *
     * https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_1_2.shtml
     *
     * @param $transactionId
     * @return mixed
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function query($transactionId)
    {
        return $this->pay()->order->queryByTransactionId($transactionId);
    }

    /**
     * 获取 jssdk
     *
     * @param $url
     * @param $apis
     * @return array|string
     * @throws InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getJsSdk($url, $apis)
    {
        return $this->app->jssdk->setUrl($url)->buildConfig($apis);
    }
}
