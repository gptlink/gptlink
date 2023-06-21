<?php

namespace App\Http\Control\Common;

use Cblink\HyperfExt\BaseController;
use Hyperf\Context\Context;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;

class DocsController extends BaseController
{
    /**
     * 查看接口 swagger 内容
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

    /**
     * 接口文档
     *
     * @param $project
     * @return mixed
     */
    public function docs($project)
    {
        $content = file_get_contents(BASE_PATH.'/storage/swagger.html');

        $content = str_replace([
            '{{ url }}',
            '{{ title }}'
        ], [
            url(sprintf('/docs/%s/swagger', $project)),
            sprintf('%s api docs', $project)
        ], $content);

        return Context::get(ResponseInterface::class)
            ->withStatus(200)
            ->withAddedHeader('content-type', 'text/html; charset=utf-8')
            ->withBody(new SwooleStream($content));
    }

}
