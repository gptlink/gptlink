<?php

namespace HyperfTest\Api;

use HyperfTest\LoginTrait;
use HyperfTest\Mock\DevelopServiceMock;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class AiImageTest extends TestCase
{
    use LoginTrait;

    public function testWebDevelopGetPrompt()
    {
        $this->userLogin();
        DevelopServiceMock::mock();

        $response = $this->get('/ai-image/prompt');
        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '提示词生成器',
            'category' => '绘画功能',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => 'id',
                '*.name' => '分类名称',
                '*.icon' => '分类图标',
                '*.prompt' => '提示词',
                "*.prompt.*.icon" => '提示词图片',
                "*.prompt.*.name" => '提示词',
                "*.prompt.*.en_name" => '提示词英文',
            ],
        ]));
    }

    public function testWebDevelopStyleModelList()
    {
        $this->userLogin();
        DevelopServiceMock::mock();

        $response = $this->get('/ai-image/style-model');

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '风格模型列表',
            'category' => '绘画功能',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                "*.id" => 'id',
                "*.name" => '风格名称',
                "*.url" => '示例图',
                "*.model_code" => "code",
                "*.model_key" => "key",
            ],
        ]));
    }

    public function testWebDevelopStyleModelShow()
    {
        $this->userLogin();
        DevelopServiceMock::mock();

        $response = $this->get('/ai-image/1/style-model', [
            'with_query' => ['size']
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '风格模型详情',
            'category' => '绘画功能',
            'params' => [
                4 => '风格模型id'
            ],
            'desc' => '',
            'request' => [
                'with_query' => '数组：size 尺寸数据'
            ],
            'request_except' => [],
            'response' => [
                "id" => 'id',
                "name" => "模型名称",
                "model_code" => 'code',
                "model_key" => "模型key",
                "url" => "示例图",
                "size.*.id" => '模型大小id',
                "size.*.style_model_id" => '风格模型id',
                "size.*.proportion" => "比例",
                "size.*.height" => '高度',
                "size.*.width" => '宽度',
                "size.*.prefine_multiple" => "精绘",
                "size.*.super_multiple" => "超分",
            ]
        ]));
    }

    public function testWebDevelopMasterModelList()
    {
        $this->userLogin();
        DevelopServiceMock::mock();

        $response = $this->get('/ai-image/master-model');
        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '基础模型列表',
            'category' => '绘画功能',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                "*.id" => 'id',
                "*.show_name" => '风格名称',
                "*.show_cover" => '示例图',
            ],
        ]));
    }

    public function testWebDevelopMasterModelShow()
    {
        $this->userLogin();
        DevelopServiceMock::mock();

        $response = $this->get('/ai-image/1/master-model', [
            'with_query' => ['size']
        ]);
        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '基础模型详情',
            'category' => '绘画功能',
            'params' => [
                4 => '基础模型id'
            ],
            'desc' => '',
            'request' => [
                'with_query' => '数组：size 尺寸数据'
            ],
            'request_except' => [],
            'response' => [
                "id" => 'id',
                "show_name" => '风格名称',
                "show_cover" => '示例图',
                "size.*.id" => '模型大小id',
                "size.*.master_model_id" => '基础模型id',
                "size.*.proportion" => "比例",
                "size.*.height" => '高度',
                "size.*.width" => '宽度',
                "size.*.prefine_multiple" => "精绘",
                "size.*.super_multiple" => "超分",
            ]
        ]));
    }

    public function testWebDevelopCreateImage()
    {
        $this->userLogin();
        DevelopServiceMock::mock();

        $response = $this->post('/ai-image', [
            'prompt' => '山，水，河流，白鹭在天上飞，渔船，蓑翁，古桥',
            'creativity_degree' => 60,
            'style_model_id' => 173,
            'style_model_size_id' => 3727,
            'master_model_id' => 1,
            'master_model_size_id' => 4,
            'init_image_url' => 'https://cdn-us.imgs.moe/2023/08/14/64d9d3cc150c3.jpg',
            'type' => 2,
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '创建作画任务',
            'category' => '绘画功能',
            'params' => [],
            'desc' => '',
            'request' => [
                'prompt' => '作画提示词',
                'creativity_degree' => '创意度 0 - 100',
                'style_model_id' => '风格模型id（文生图时，必传）',
                'style_model_size_id' => '风格模型尺寸id（文生图时，必传）',
                'master_model_id' => '基础模型id（图生图必传）',
                'master_model_size_id' => '基础模型尺寸id（图生图必传）',
                'init_image_url' => '图生图底图： 图生图时必传',
                'type' => '1 文生图 2 图生图',
            ],
            'request_except' => [],
            'response' => [
                "draw_id" => '作画id',
                "status" => '作画状态，固定为：生成中',
                "expected_second" => '预计耗时',
            ]
        ]));
    }

    public function testWebDevelopCostIntegral()
    {
        $this->userLogin();

        DevelopServiceMock::mock();

        $response = $this->post('/ai-image/cost', [
            'prompt' => '山，水，河流，白鹭在天上飞，渔船，蓑翁，古桥',
            'creativity_degree' => 60,
            'style_model_id' => 173,
            'style_model_size_id' => 3720,
            'master_model_id' => 1,
            'master_model_size_id' => 4,
            'init_image_url' => 'https://cdn-us.imgs.moe/2023/08/14/64d9d3cc150c3.jpg',
            'type' => 2,
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '计算作画成本',
            'category' => '绘画功能',
            'params' => [],
            'desc' => '',
            'request' => [
                'prompt' => '作画提示词',
                'creativity_degree' => '创意度 0 - 100',
                'style_model_id' => '风格模型id',
                'style_model_size_id' => '风格模型尺寸id',
                'master_model_id' => '基础模型id',
                'master_model_size_id' => '基础模型尺寸id',
                'init_image_url' => '图生图底图： 图生图时必传',
                'type' => '1 文生图 2 图生图',
            ],
            'request_except' => [],
            'response' => [
                "total_basic_integral" => '基础作画积分',
                "total_proportion_integral" => '基础尺寸积分',
                "total_integral" => '最终消耗总积分',
            ]
        ]));

    }

    public function testWebDevelopImageShow()
    {
        $this->userLogin();
        DevelopServiceMock::mock();
        $response = $this->get('/ai-image/121');

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '作画详情',
            'category' => '绘画功能',
            'params' => [
                4 => '作画任务id'
            ],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => '图片id',
                'url' => '图片url',
                'draw_id' => '作画任务id',
                'status' => '状态,1 : 创作中,2 : 成功,3 : 失败,4 : 违规',
                'created_at' => '2022-06-05 10:00:00',
                'type' => '1 文生图 2 图生图',
                'size' => '尺寸',
                'proportion' => '图片比例',
                'init_image_url' => '图生图-底图',
            ]
        ]));
    }

    public function testWebDevelopImageLists()
    {
        $this->userLogin();
        DevelopServiceMock::mock();

        $response = $this->get('/ai-image');
        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '我的作画列表',
            'category' => '绘画功能',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => '图片id',
                '*.url' => '图片url',
                '*.draw_id' => '作画任务id',
                '*.status' => '状态,1 : 创作中,2 : 成功,3 : 失败,4 : 违规',
                '*.created_at' => '2022-06-05 10:00:00',
                '*.type' => '1 文生图 2 图生图',
                '*.size' => '尺寸',
                '*.proportion' => '图片比例',
                '*.init_image_url' => '图生图-底图',
            ]
        ]));
    }
}
