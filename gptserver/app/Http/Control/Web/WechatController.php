<?php

namespace App\Http\Control\Web;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\OauthDto;
use App\Http\Service\MemberOauthService;
use App\Http\Service\WechatService;
use App\Model\Config;
use Cblink\Hyperf\Socialite\Contracts\SocialiteInterface;
use Cblink\HyperfExt\BaseController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class WechatController extends BaseController
{
    /**
     * 微信重定向
     *
     * @param RequestInterface $request
     * @param $platform
     * @return ResponseInterface
     */
    public function redirect(RequestInterface $request, $platform)
    {
        $redirectUrl = $request->input('redirect_url');
        // 读取配置项
        $config = Config::getWechatConfig($platform);
        $data = array_merge(array_filter(
            ['redirect_url' => $redirectUrl]
        ), $config);

        // 跳板地址
        return make(SocialiteInterface::class)
            ->driver($platform)
            ->setConfig($data, false)
            ->redirect();
    }

    /**
     * 扫码登录
     *
     * @param RequestInterface $request
     * @param mixed $platform
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function qrcode(RequestInterface $request, $platform)
    {
        $redirectUrl = $request->input('redirect_url');

        // 读取配置项
        $config = Config::getWechatConfig($platform);
        $data = array_merge(array_filter(['redirect_url' => $redirectUrl]), $config);

        $qrCode = make(SocialiteInterface::class)
            ->driver($platform)
            ->setConfig($data, false)
            ->getAuthUrl('');

        return $this->success([
            'qr_code_url' => $qrCode,
        ]);
    }

    /**
     * 用户登录
     *
     * @param mixed $platform
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function code2User($platform)
    {
        // 读取配置项
        $config = Config::getWechatConfig($platform);

        $user = make(SocialiteInterface::class)
            ->driver($platform)
            ->setConfig($config)
            ->stateless()
            ->user();

        throw_unless($user->id, LogicException::class, ErrCode::WECHAT_OPENID_GET_FAIL);

        return $this->success([
            'user' => base64_encode($user->id),
        ]);
    }

    /**
     * @param RequestInterface $request
     * @param WechatService $service
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function jssdk(RequestInterface $request, WechatService $service)
    {
        try {
            $jssdk = $service->getJsSdk($request->input('url'), $request->input('apis', []), false);
        } catch (\Exception $exception) {
            logger('exception')->info('jssdk exception', [
                'message' => $exception->getMessage(),
            ]);

            $jssdk = $this->success([
                'appId' => '',
                'nonceStr' => '',
                'timestamp' => '',
                'url' => '',
                'signature' => '',
            ]);
        }

        return $this->success([
            'data' => $jssdk,
        ]);
    }

    /**
     * 用户登录
     *
     * @param $platform
     * @param RequestInterface $request
     * @param MemberOauthService $memberOauthService
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function login($platform, RequestInterface $request, MemberOauthService $memberOauthService)
    {
        $config = Config::getWechatConfig($platform);

        $driver = make(SocialiteInterface::class)
            ->driver($platform)
            ->setConfig($config);

        $user = $driver->stateless()->user();

        throw_unless($user->getId(), LogicException::class, ErrCode::WECHAT_OPENID_GET_FAIL);

        $memberOrOath = $memberOauthService->oauthLogin(new OauthDto([
            'nickname' => $user->getNickname(),
            'avatar' => $user->getAvatar(),
            'openid' => $user->getId(),
            'unionid' => $user->offsetGet('unionid') ?? '',
            'platform' => $platform,
            'appid' => $driver->getClientId(),
            'share_openid' => $request->input('share_openid'),
            'source' => $request->input('source'),
        ]));

        return $this->success($memberOrOath);
    }
}
