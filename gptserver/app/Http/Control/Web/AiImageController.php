<?php

namespace App\Http\Control\Web;

use App\Http\Dto\Config\AiChatConfigDto;
use App\Http\Dto\Config\SmsConfigDto;
use App\Http\Request\Admin\ModelShowRequest;
use App\Http\Resource\Admin\DevelopPackageResource;
use App\Http\Service\DevelopService;
use App\Model\Config;
use Cblink\HyperfExt\BaseController;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\SimpleCache\InvalidArgumentException;

class AiImageController extends BaseController
{
    /**
     * 提示词生成器
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getPrompt(DevelopService $service)
    {
        $result = $service->getPrompt();
        return $this->success($result);
    }

    /**
     * 风格模型列表
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getStyleModellists(DevelopService $service)
    {
        $result = $service->getStyleModellists();
        return $this->success($result);
    }

    /**
     * 风格模型详情
     * @param $id
     * @param ModelShowRequest $request
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getStyleModel($id, ModelShowRequest $request, DevelopService $service)
    {
        $result = $service->getStyleModel($id, $request->validated());
        return $this->success($result);
    }

    /**
     * 基础模型列表
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getMasterModellists(DevelopService $service)
    {
        $result = $service->getMasterModellists();
        return $this->success($result);
    }

    /**
     * 基础作画模型详情
     * @param $id
     * @param ModelShowRequest $request
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getMasterModel($id, ModelShowRequest $request, DevelopService $service)
    {
        $result = $service->getMasterModel($id, $request->validated());
        return $this->success($result);
    }

    /**
     * 创建作画任务
     * @param RequestInterface $request
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(RequestInterface $request, DevelopService $service)
    {
        $result = $service->create($request->all());
        return $this->success($result);
    }

    /**
     * 计算作画成本
     * @param RequestInterface $request
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getCost(RequestInterface $request, DevelopService $service)
    {
        $result = $service->getCost($request->all());
        return $this->success($result);
    }

    /**
     * 我的绘画详情
     * @param $id
     * @param RequestInterface $request
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show($id, RequestInterface $request, DevelopService $service)
    {
        $result = $service->show($id, $request->all());
        return $this->success($result);
    }

    /**
     * 我的绘画列表
     * @param RequestInterface $request
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getDrawlists(RequestInterface $request, DevelopService $service)
    {
        $result = $service->getDrawlists($request->all());
        return $this->success($result);
    }
}
