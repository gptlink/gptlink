<?php

namespace App\Http\Control\Common;

use App\Http\Request\QiniuRequest;
use App\Http\Service\QiniuService;
use Cblink\HyperfExt\BaseController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Qiniu\Storage\UploadManager;

class QiniuController extends BaseController
{
	/**
	 * 获取七牛上传token
	 * @param QiniuService $qiniuService
	 * @return ResponseInterface
	 */
    public function getUploadToken(QiniuRequest $request, QiniuService $qiniuService)
	{
		$token = $qiniuService->getUploadToken($request->input('path'));

		return $this->success([
			'token' => $token,
			'domain' => config('custom.qiniu.domain')
		]);
	}
}
