<?php

namespace App\Http\Service;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use Qiniu\Auth;

/**
 * 七牛云服务
 */
class QiniuService
{
    protected $auth;

    public function __construct()
    {
        $this->auth = new Auth(config('custom.qiniu.access_key'), config('custom.qiniu.secret_key'));
    }

	/**
	 * 获取上传token
	 * @param string $path 上传路径
	 * @return string
	 */
	public function getUploadToken(string $path)
	{
		return $this->auth->uploadToken(
            config('custom.qiniu.bucket'), $path, config('custom.qiniu.expires')
        );
	}

    /**
     * 七牛文件信息
     *
     * @param $fileUrl
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function getFileInfo($fileUrl)
    {
        $url = sprintf('%s?imageInfo', $fileUrl);
        $response = (new \GuzzleHttp\Client([
            'timeout' => 10,
        ]))->get($url);

        throw_if($response->getStatusCode() !== 200, LogicException::class, ErrCode::MATERIAL_CATEGORY_FILE_INFO);
        return json_decode($response->getBody()->getContents(), true);
    }
}
