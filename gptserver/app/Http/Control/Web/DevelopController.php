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

class DevelopController extends BaseController
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
    public function getStyleModelShow($id, ModelShowRequest $request, DevelopService $service)
    {
        $result = $service->getStyleModelShow($id, $request->validated());
        return $this->success($result);
    }

    /**
     * 基础模型列表
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function masterModellists(DevelopService $service)
    {
        $result = $service->masterModellists();
        return $this->success($result);
    }

    /**
     * 基础作画模型详情
     * @param $id
     * @param ModelShowRequest $request
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function masterModelShow($id, ModelShowRequest $request, DevelopService $service)
    {
        $result = $service->masterModelShow($id, $request->validated());
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
    public function cost(RequestInterface $request, DevelopService $service)
    {
        $result = $service->cost($request->all());
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
    public function lists(RequestInterface $request, DevelopService $service)
    {
        $result = $service->lists($request->all());
        return $this->success($result);
    }
}
