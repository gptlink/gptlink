<?php

namespace App\Http\Service;

use App\Http\Dto\Config\WechatPlatformDto;
use App\Model\Config;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\OfficialAccount\Application;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\Guzzle\CoroutineHandler;

class WechatService
{
    protected $app;

    public function __construct()
    {
        /* @var WechatPlatformDto $dto */
        $dto = Config::toDto(Config::WECHAT_PLATFORM);

        $this->app = new Application([
            'app_id' => $dto->client_id,
            'secret' => $dto->client_secret,
        ]);
        // 设置handler
        $handler = new CoroutineHandler();
        $config = $this->app['config']->get('http', []);
        $config['handler'] = HandlerStack::create($handler);
        $this->app->rebind('http_client', new Client($config));
        $this->app->rebind('logger', logger());
        $this->app->rebind('cache', cache());
        $this->app['guzzle_handler'] = $handler;
    }

    /**
     * 获取 jssdk
     *
     * @param $url
     * @param array $apis
     * @param bool|mixed $json
     * @param bool|mixed $debug
     * @return array|string
     * @throws InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getJsSdk($url, array $apis = [], bool $json = true, bool $debug = false)
    {
        return $this->app->jssdk->setUrl($url)->buildConfig($apis, $debug, false, $json);
    }
}
