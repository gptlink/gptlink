<?php

namespace App\Http\Control\Common;

use App\Http\Dto\MaterialDto;
use App\Http\Request\Admin\ImageRequest;
use App\Http\Request\QiniuRequest;
use App\Http\Service\QiniuService;
use App\Model\Material;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;

class UploadController extends BaseController
{
    /**
     * 获取七牛上传token
     *
     *
     * @param QiniuRequest $request
     * @param QiniuService $qiniuService
     * @return ResponseInterface
     */
    public function getQiniuToken(QiniuRequest $request, QiniuService $qiniuService)
	{
		$token = $qiniuService->getUploadToken($request->input('path'));

		return $this->success([
			'token' => $token,
			'domain' => config('custom.qiniu.domain'),
		]);
	}

    /**
     * 上传图片
     *
     * @return ResponseInterface
     */
    public function uploadImage(ImageRequest $request)
    {
        $material = Material::createByDto(new MaterialDto($request->validated()));

        return $this->success([
            'image' => $material->file_url,
        ]);
    }
}
