<?php

namespace Api\Admin\Config;

use App\Http\Dto\Config\ShareConfigDto;
use App\Model\Config;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

class WechatShareConfigTest extends TestCase
{
    use LoginTrait;

    public function testAdminWechatShareShow()
    {
        $this->AdminLogin();

        Config::updateOrCreateByDto(new ShareConfigDto([]));

        $response = $this->get(sprintf('/admin/config/%s',  Config::SHARE));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取分享配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'title' => '分享标题',
                'desc' => '分享描述',
                'img_url' => '分享到微信的图',
                'share_img' => '分享任务图',
            ],
        ]));
    }

    /**
     * admin
     *
     * @return void
     * @throws \Throwable
     */
    public function testPostWechatShare()
    {
        $this->AdminLogin();

        $response = $this->post(sprintf('/admin/config/%s', Config::SHARE), [
            'config' => [
                'title' => '分享标题',
                'desc' => '分享描述',
                'img_url' => '分享到微信的图',
                'share_img' => '分享任务图',
            ],
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存分享配置',
            'category' => '配置项',
            'params' => [],
            'desc' => '',
            'request' => [
                'config.title' => '分享标题',
                'config.desc' => '分享描述',
                'config.img_url' => '分享到微信的图',
                'config.share_img' => '分享任务海报',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

}
