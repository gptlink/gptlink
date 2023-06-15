<?php

namespace App\Http\Control\Common;

use Cblink\HyperfExt\BaseController;
use Hyperf\Context\Context;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;

class DocsController extends BaseController
{

    /**
     * 查看接口文档 swagger 内容
     *
     * @param $project
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function swagger($project)
    {
        $response = Context::get(ResponseInterface::class);

        $path = sprintf('%s/storage/swagger/%s-swagger.json',BASE_PATH, $project);

        $result = file_exists($path) ?
            file_get_contents($path) :
            '[]';

        return $response
            ->withStatus(200)
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream($result));
    }

}
