<?php

namespace App\Http\Control\Common;

use App\Model\Material;
use Cblink\HyperfExt\BaseController;
use Hyperf\Context\Context;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;

class ImageController extends BaseController
{
    /**
     * 图片
     *
     * @param $fileName
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show($fileName)
    {
        $material = Material::query()
            ->where('file_url', $fileName)
            ->firstOrFail();

        $response = Context::get(ResponseInterface::class);

        return $response
            ->withStatus(200)
            ->withAddedHeader('content-type', $material->format)
            ->withBody(new SwooleStream(base64_decode($material->content)));
    }

}
