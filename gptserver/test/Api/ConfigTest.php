<?php

namespace HyperfTest\Api;

use Hyperf\Utils\Arr;
use HyperfTest\Factory\ConfigFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class ConfigTest extends TestCase
{
    use LoginTrait;

	public function testWebConfigBasicInfoShow()
	{
		$config = ConfigFactory::createGptSecretKeyData();

		$response = $this->get('/config/basic-info');
$response->dump();
        $this->assertApiSuccess($response);

		ConfigFactory::deleteById($config->id);

		$response->build(new BaseDto([
			'project' => ['default'],
			'name' => '获取备案号与logo',
			'category' => '配置相关',
			'params' => [],
			'desc' => '',
			'request' => [],
			'request_except' => [],
			'response' => [
                'icp' => 'icp备案号',
                'web_logo' => '图片 base64',
                'admin_logo' => '图片 base64'
            ],
		]));
	}
}
