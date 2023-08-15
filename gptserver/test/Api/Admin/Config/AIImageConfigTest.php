<?php

namespace HyperfTest\Api\Admin\Config;

use App\Http\Dto\Config\AiImageConfigDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class AIImageConfigTest extends TestCase
{
    use LoginTrait;

    public function testAdminAiImageConfigShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new AiImageConfigDto([]));

        $response = $this->get(sprintf('/admin/config/%s', Config::AI_IMAGE));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取无界绘画配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'type' => '配置项类型 固定为 12',
                'config' => '配置项',
                'config.gptlink_key' => 'gpt密钥',
                'config.gptlink_base_url' => 'gptlink接口地址',
                'config.channel' => BaseDto::mapDesc('使用渠道', AiImageConfigDto::CHANNEL),
            ],
        ]));
    }

    /**
     * admin
     *
     * @return void
     * @throws \Throwable
     */
    public function testPostAdminAiImageConfig()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::AI_IMAGE), [
            'config' => [
                'channel' => AiImageConfigDto::CHANNEL_GPT_LINK,
                'gptlink_key' => 'xxxx',
                'gptlink_base_url' => 'https://www.baidu.com',
            ],
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存绘图配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [
                'config' => '配置项',
                'config.gptlink_key' => 'gpt密钥',
                'config.gptlink_base_url' => 'gptlink接口地址',
                'config.channel' => BaseDto::mapDesc('使用渠道', AiImageConfigDto::CHANNEL),
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

}
