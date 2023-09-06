<?php

namespace App\Http\Service;

use App\Exception\RemoteException;
use App\Http\Dto\Config\AiChatConfigDto;
use App\Http\Dto\Config\AiImageConfigDto;
use App\Model\Config;
use Cblink\Service\Develop\Application;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Utils\Arr;

class GPTLinkChatService
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct($apiKey = null)
    {
        if (! $apiKey) {
            /* @var AiChatConfigDto $aiChat  */
            $aiChat = Config::toDto(Config::AI_CHAT);
            $apiKey = $aiChat->gptlink_key;
        }

        if (! $apiKey) {
            /* @var AiImageConfigDto $aiImg  */
            $aiImg = Config::toDto(Config::AI_IMAGE);
            $apiKey = $aiImg->gptlink_key;
        }

        $config = [
            'api_key' => $apiKey,
            'base_url' => \config('openai.base_url'),
        ];

        $this->app = new Application($config);
    }

    /**
     * 获取个人信息
     *
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function getProfile(array $query = []): array
    {
        $response = $this->app->user->profile($query);

        return $this->formatResponse($response, true);
    }

    /**
     * 获取开发者套餐信息
     *
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function getPackage(array $query = []): array
    {
        $response = $this->app->user->package($query);

        return $this->formatResponse($response, true);
    }

    /**
     * 获取开发者消费记录
     *
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function getRecord(array $query = []): array
    {
        $response = $this->app->user->record($query);
        return $this->formatResponse($response, true);
    }


    /**
     * @param $response
     * @param bool $returnData
     * @return array
     * @throws \Throwable
     */
    public function formatResponse($response, bool $returnData = false): array
    {
        throw_unless(
            Arr::get($response, 'err_code') == 0,
            RemoteException::class,
            Arr::get($response, 'err_msg', ''),
            Arr::get($response, 'err_code', 0),
            'gpt-link'
        );

        if ($returnData) {
            return $response['data'];
        }

        return $response;
    }
}
