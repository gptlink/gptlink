<?php

namespace App\Base\OpenAi;

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
     * @var mixed|null
     */
    protected $chatKeyType;

    public function __construct($keyType = null)
    {
        $this->chatKeyType = $keyType;
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
            $clientConfig = array_filter([config('openai.chat.host'), config('openai.chat.port')]);

            if (! $clientConfig) {
                $clientConfig = match ($this->chatKeyType){
                    WebsiteConfigDto::OPENAI => ['api.openai.com', 443, true],
                    default => ['api.gpt-link.com', 443, true],
                };
            } else {
                $clientConfig[] = config('openai.chat.port') == 443;
            }

            $this->client = new Client(...$clientConfig);

            $options = ['timeout' => -1];

            if (config('openai.chat.proxy.socks5_host') && config('openai.chat.proxy.socks5_port')) {
                $options = array_merge([
                    'socks5_host' => config('openai.chat.proxy.socks5_host'),
                    'socks5_port' => config('openai.chat.proxy.socks5_port'),
                    'ssl_host_name' => config('openai.chat.host'),
                ], $options);
            }
            $this->client->set($options);
        }

        return $this->client;
    }
}
