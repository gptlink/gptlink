<?php

namespace App\Http\Service;

use App\Exception\RemoteException;
use App\Http\Dto\Config\AiImageConfigDto;
use App\Model\Config;
use Cblink\Service\Develop\Application;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Utils\Arr;

/**
 * 开发者服务
 */
class DevelopService
{
    /**
     * @var AiImageConfigDto
     */
    protected $config;

    protected $app;

    public function __construct()
    {
        $this->config = Config::toDto(Config::AI_IMAGE);
        $config = [
            'api_key' => $this->config->gptlink_key,
            'base_url' => $this->config->gptlink_base_url,
        ];

        $this->app = new Application($config);
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

    /**
     * 获取个人信息
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function getProfile($query = [])
    {
        $response = $this->app->user->profile($query);
        return $this->formatResponse($response, true);
    }

    /**
     * 获取开发者套餐信息
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function getPackage($query = [])
    {
        $response = $this->app->user->package($query);
        return $this->formatResponse($response, true);
    }

    /**
     * 获取开发者消费记录
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function getRcord($query = [])
    {
        $response = $this->app->user->record($query);
        return $this->formatResponse($response, true);
    }

    /**
     * 提示词生成器
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function getPrompt($query = [])
    {
        $response = $this->app->prompt->lists($query);
        return $this->formatResponse($response, true);
    }

    /**
     * 风格模型列表
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function getStyleModellists($query = [])
    {
        $response = $this->app->model->styleModellists($query);
        return $this->formatResponse($response, true);
    }

    /**
     * 风格模型详情
     * @param $id
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function getStyleModel($id, $query = [])
    {
        $response = $this->app->model->styleModelShow($id, $query);
        return $this->formatResponse($response, true);
    }

    /**
     * 基础模型列表
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function getMasterModellists($query = [])
    {
        $response = $this->app->model->masterModellists($query);
        return $this->formatResponse($response, true);
    }

    /**
     * 基础作画模型详情
     * @param $id
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function getMasterModel($id, $query = [])
    {
        $response = $this->app->model->masterModelShow($id, $query);
        return $this->formatResponse($response, true);
    }

    /**
     * 创建作画任务
     * @param $data
     * @return array
     * @throws GuzzleException
     */
    public function create($data = [])
    {
        $response = $this->app->image->create($data);
        return $this->formatResponse($response, true);
    }

    /**
     * 计算作画成本
     * @param $data
     * @return array
     * @throws GuzzleException
     */
    public function getCost($data = [])
    {
        $response = $this->app->image->cost($data);
        return $this->formatResponse($response, true);
    }

    /**
     * 我的绘画详情
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
     * @param $query
     * @return array
     * @throws GuzzleException
     */
    public function getDrawlists($query = [])
    {
        $response = $this->app->image->lists($query);
        return $this->formatResponse($response, true);
    }

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
