<?php

namespace App\Http\Service;

use App\Exception\RemoteException;
use App\Http\Dto\Config\AiChatConfigDto;
use App\Model\Config;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Utils\Arr;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * 开发者服务
 */
class DevelopService
{
    /**
     * @var AiChatConfigDto
     */
    protected $config;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
        $this->config = Config::toDto(Config::AI_CHAT);
    }

    /**
     * 获取套餐包信息
     * @return array
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws \Throwable
     */
    public function getPackage(array $query = [])
    {
        return $this->request('/v1/user/package', [
            'query' => $query,
        ], [
            'Authorization' => sprintf('Bearer %s', $this->config->gptlink_key),
        ]);
    }

    /**
     * 封装的请求方法
     * @param string $path
     * @param array $options
     * @param array $header
     * @param string $method
     * @return array
     * @throws GuzzleException
     * @throws \Throwable
     */
    protected function request(string $path, array $options = [], array $header = [], string $method = 'GET')
    {
        // 创建客户端
        $client = $this->clientFactory->create();

        $response = $client->request($method, $this->getRequestUrl($path), array_merge([
            'timeout' => 5,
            'verify' => false,
            'http_errors' => false,
            'headers' => $header, // 添加header
        ], $options));

        // 获取响应内容
        return json_decode($response->getBody()->getContents(), true);
        /*
        throw_unless(
            Arr::get($response, 'err_code') == 0,
            RemoteException::class,
            Arr::get($response, 'err_msg', ''),
            Arr::get($response, 'err_code', 0),
        );
        */
    }

    /**
     * 获取请求地址
     *
     * @param string $path
     * @return string
     */
    protected function getRequestUrl(string $path = '')
    {
        return sprintf('%s%s', \config('openai.base_url'), ltrim($path, '/'));
    }
}
