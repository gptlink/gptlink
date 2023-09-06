<?php

namespace App\Http\Control\Web;

use App\Http\Request\Admin\ModelShowRequest;
use App\Http\Service\GPTLinkImageService;
use Cblink\HyperfExt\BaseController;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AiImageController extends BaseController
{
    /**
     * 提示词生成器
     *
     * @param GPTLinkImageService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getPrompt(GPTLinkImageService $service)
    {
        $result = $service->getPrompt();
        return $this->success($result);
    }

    /**
     * 风格模型列表
     *
     * @param GPTLinkImageService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getStyleModellists(GPTLinkImageService $service)
    {
        $result = $service->getStyleModelLists();
        return $this->success($result);
    }

    /**
     * 风格模型详情
     *
     * @param $id
     * @param ModelShowRequest $request
     * @param GPTLinkImageService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getStyleModel(ModelShowRequest $request, GPTLinkImageService $service, $id)
    {
        $result = $service->getStyleModel($id, $request->validated());

        return $this->success($result);
    }

    /**
     * 基础模型列表
     *
     * @param GPTLinkImageService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getMasterModellists(GPTLinkImageService $service)
    {
        $result = $service->getMasterModelLists();

        return $this->success($result);
    }

    /**
     * 基础作画模型详情
     *
     * @param $id
     * @param ModelShowRequest $request
     * @param GPTLinkImageService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getMasterModel(ModelShowRequest $request, GPTLinkImageService $service, $id)
    {
        $result = $service->getMasterModel($id, $request->validated());

        return $this->success($result);
    }

    /**
     * 创建作画任务
     *
     * @param RequestInterface $request
     * @param GPTLinkImageService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function create(RequestInterface $request, GPTLinkImageService $service)
    {
        $result = $service->create($request->all());

        return $this->success($result);
    }

    /**
     * 计算作画成本
     *
     * @param RequestInterface $request
     * @param GPTLinkImageService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getCost(RequestInterface $request, GPTLinkImageService $service)
    {
        $result = $service->getCost($request->all());

        return $this->success($result);
    }

    /**
     * 我的绘画详情
     *
     * @param $id
     * @param RequestInterface $request
     * @param GPTLinkImageService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function show(RequestInterface $request, GPTLinkImageService $service, $id)
    {
        $result = $service->show($id, $request->all());

        return $this->success($result);
    }

    /**
     * 我的绘画列表
     *
     * @param RequestInterface $request
     * @param GPTLinkImageService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getDrawlists(RequestInterface $request, GPTLinkImageService $service)
    {
        $result = $service->getImages($request->all());

        return $this->success($result);
    }
}
