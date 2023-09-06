<?php

namespace App\Http\Service;

use App\Exception\RemoteException;
use App\Http\Dto\Config\AiImageConfigDto;
use App\Model\Config;
use Cblink\Service\Develop\Application;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Utils\Arr;

class GPTLinkImageService
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct(string $apiKey = null)
    {
        if (!$apiKey) {
            /* @var AiImageConfigDto $aiChat  */
            $aiChat = Config::toDto(Config::AI_IMAGE);

            $apiKey = $aiChat->gptlink_key;
        }

        $config = [
            'api_key' => $apiKey,
            'base_url' => \config('openai.base_url'),
        ];

        $this->app = new Application($config);
    }

    /**
     * 提示词生成器
     *
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function getPrompt(array $query = []): array
    {
        $response = $this->app->prompt->lists($query);
        return $this->formatResponse($response, true);
    }

    /**
     * 风格模型列表
     *
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function getStyleModelLists(array $query = []): array
    {
        $response = $this->app->model->styleModellists($query);
        return $this->formatResponse($response, true);
    }

    /**
     * 风格模型详情
     *
     * @param $id
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function getStyleModel($id, array $query = []): array
    {
        $response = $this->app->model->styleModelShow($id, $query);
        return $this->formatResponse($response, true);
    }

    /**
     * 基础模型列表
     *
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function getMasterModelLists(array $query = []): array
    {
        $response = $this->app->model->masterModellists($query);
        return $this->formatResponse($response, true);
    }

    /**
     * 基础作画模型详情
     *
     * @param $id
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function getMasterModel($id, array $query = []): array
    {
        $response = $this->app->model->masterModelShow($id, $query);
        return $this->formatResponse($response, true);
    }

    /**
     * 创建作画任务
     *
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function create(array $data = []): array
    {
        $response = $this->app->image->create($data);
        return $this->formatResponse($response, true);
    }

    /**
     * 计算作画成本
     *
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function getCost(array $data = []): array
    {
        $response = $this->app->image->cost($data);
        return $this->formatResponse($response, true);
    }

    /**
     * 我的绘画详情
     *
     * @param $id
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function show($id, $query = [])
    {
        $response = $this->app->image->show($id, $query);
        return $this->formatResponse($response, true);
    }

    /**
     * 我的绘画列表
     *
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function getImages(array $query = []): array
    {
        $response = $this->app->image->lists($query);
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
