<?php

namespace HyperfTest\Api;

use HyperfTest\LoginTrait;
use HyperfTest\Mock\QiniuServiceMock;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class QiniuTest extends TestCase
{
    use LoginTrait;

    public function testGetQiniuUploadToken()
	{
		$this->userLogin();
		QiniuServiceMock::mock();

		$response = $this->get('/qiniu/token', [
			'path' => 'test'
		]);

		$this->assertApiSuccess($response);

		$response->build(new BaseDto([
			'project'        => ['default'],
			'name'           => '用户端获取七牛上传token',
			'category'       => '七牛云',
			'desc'           => '',
			'request'        => [],
			'request_except' => [],
			'response'       => [
				'token'      => '七牛云上传token',
				'domain'     => '加速域名',
			],
		]));
	}

	public function testGetAdminQiniuUploadToken()
	{
		$this->adminLogin();
		QiniuServiceMock::mock();

		$response = $this->get('/admin/qiniu/token', [
			'path' => 'test'
		]);

		$this->assertApiSuccess($response);

		$response->build(new BaseDto([
			'project'        => ['default'],
			'name'           => '管理端获取七牛上传token',
			'category'       => '七牛云',
			'desc'           => '',
			'request'        => [],
			'request_except' => [],
			'response'       => [
				'token'      => '七牛云上传token',
				'domain'     => '加速域名',
			],
		]));
	}
}
