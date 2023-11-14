<?php

namespace App\Base\OpenAi;

use App\Http\Dto\Config\AiChatConfigDto;
use App\Http\Dto\Config\WebsiteConfigDto;
use Hyperf\HttpMessage\Server\Connection\SwooleConnection;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Swoole\Coroutine\Http2\Client;
use Swoole\Http2\Request;

class OpenAIClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Request
     */
    protected $req;

    /**
     * @var
     */
    protected $response;

    /**
     * @var int 数据流ID
     */
    protected $stream_id;

    /**
     * @var string
     */
    protected $debug = '';

    /**
     * @var AiChatConfigDto|null
     */
    protected $config;

    public function __construct(AiChatConfigDto $config = null)
    {
        $this->config = $config;
        $this->connect();
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     */
    public function exec(RequestInterface $request)
    {
        return $request->send($this);
    }

    /**
     * @return mixed|ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function response()
    {
        if (! $this->response) {
            $response = app()->get(ResponseInterface::class);
            /* @var SwooleConnection $connect */

            $connect = $response->getConnection();
            $connect->setHeader('content-Type', 'text/event-stream');
            $connect->setHeader('access-control-allow-origin', '*');
            $connect->setHeader('vary', 'origin');
            $connect->setHeader('access-control-allow-methods', 'POST');
            $response->setConnection($connect);

            $this->response = $response;
        }

        return $this->response;
    }

    /**
     * @return $this
     */
    public function connect()
    {
        $this->getClient()->connect();

        return $this;
    }

    /**
     * @return $this
     */
    public function reconnect()
    {
        $this->close();
        sleep(1);
        $this->connect();

        return $this;
    }

    /**
     * @return $this
     */
    public function close()
    {
        $this->getClient()->close();

        return $this;
    }

    /**
     * @param null|mixed $timeout
     * @return mixed
     */
    public function read($timeout = null)
    {
        return $this->getClient()->read($timeout);
    }

    /**
     * @return int
     */
    public function send(Request $request)
    {
        return $this->getClient()->send($request);
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        if (! $this->client) {
            $clientConfig = match ($this->config->channel){
                AiChatConfigDto::OPENAI => function () {
                    if (! empty($this->config->openai_host)) {
                        $host = parse_url($this->config->openai_host);
                        $port = (int) $host['port'] ?: ($host['scheme'] == 'https' ? 443: 80);
                        return [$host['host'], $port, $port == 443];
                    }
                    return ['api.openai.com', 443, true];
                },
                default => ['api.aiyaaa.net', 443, true],
            };

            if ($clientConfig instanceof \Closure) {
                $clientConfig = $clientConfig();
            }

            $this->client = new Client(...$clientConfig);

            $options = ['timeout' => -1];

            if ($this->config->channel == AiChatConfigDto::OPENAI) {
                // 如果有代理，则添加代理
                if (! empty($this->config->openai_proxy_host)) {
                    $proxy = explode(':', $this->config->openai_proxy_host);
                    $options = array_merge([
                        'socks5_host' => $proxy[0],
                        'socks5_port' => $proxy[1],
                        'ssl_host_name' => $clientConfig[0],
                    ], $options);
                }
            }
            $this->client->set($options);
        }

        return $this->client;
    }
}
