<?php

namespace HyperfTest\Mock;

use App\Http\Service\DevelopService;

class DevelopServiceMock
{
    public static function mock()
    {
        $service = \Mockery::mock(DevelopService::class)->makePartial();

        $service->allows()->getPackage(\Mockery::any())->andReturn([
            'chat' => [
                'name' => '聊天套餐包',
                'num' => '6000',
                'used' => '10',
                'expired_at' => '2099-05-05 10:10:10'
            ]
        ]);

        $service->allows()->getProfile()->andReturn([
            "openid" => "838c99deea7d966f",
            "nickname" => "。",
            "avatar" => "https://thirdwx.qlogo.cn/mmopen/vi_32/0iaubgZxG3knvyGhKjFlX1hnvy6lmpsIrTrM3rFib3hytaFsdLsD9oPuuoGZpDOrvia9lAUicRfrgQuic7WUEfkt83g/132",
            "status" => 1
        ]);

        $service->allows()->getRcord()->andReturn([
            [
                "id" => 809,
                "user_id" => 101,
                "package_id" => 118,
                "package_name" => "测试-新用户注册+2次",
                "channel" => 12,
                "type" => 12,
                "num" => 0,
                "symbol" => 2,
                "created_at" => "2023-08-11 03:18:45"
            ]
        ]);

        $service->allows()->getPrompt()->andReturn([
            [
                'id' => 1,
                'name' => '芬理希梦',
                'icon' => 'fa fa- ',
                'prompt' =>
                    [
                        [
                            "icon" => 'https://i.ytimg.com/vi/xxx.jpg',
                            "name" => '大事作品',
                            "en_name" => 'enen-dmmd',
                        ]
                    ]
            ]
        ]);

        $service->allows()->getStyleModellists()->andReturn([
            [
                "id" => 809,
                "name" => '水漫金山',
                "url" => 'https://i.ytimg.com/vi/xxx.jpg',
                "model_code" => "stm-订单",
                "model_key" => "30",
            ]
        ]);

        $service->allows()->getStyleModel(\Mockery::any(), \Mockery::any())->andReturn([
            "id" => 1,
            "name" => "全息摄影",
            "model_code" => 110,
            "model_key" => "stm-C2OPPAYS",
            "url" => "https://cdn.gpt-link.com/GPT/dev/wj_style_model/example_pic/model_1.png",
            "size" => [
                [
                    "id" => 4,
                    "style_model_id" => 1,
                    "proportion" => "16:9",
                    "height" => 448,
                    "width" => 768,
                    "prefine_multiple" => "1",
                    "super_multiple" => "1",
                    "integral" => 1
                ]
            ],
            "prompt" => [
                [
                    "id" => 2759,
                    "style_model_id" => 1,
                    "prompt" => "淡蓝色长发女孩 "
                ],
            ]
        ]);

        $service->allows()->getMasterModellists()->andReturn([
            [
                "id" => 809,
                "show_name" => '风格名称',
                "show_cover" => 'https://cdn.gpt-link.com/GPT/dev/wj_style_model/example_pic/model_1.png',
            ]
        ]);

        $service->allows()->getMasterModel(\Mockery::any(), \Mockery::any())->andReturn([
            "id" => 1,
            "show_name" => '风格名称',
            "show_cover" => 'https://cdn.gpt-link.com/GPT/dev/wj_style_model/example_pic/model_1.png',
            "size" => [
                [
                    "id" => 4,
                    "style_model_id" => 1,
                    "proportion" => "16:9",
                    "height" => 448,
                    "width" => 768,
                    "prefine_multiple" => "1",
                    "super_multiple" => "1",
                    "integral" => 1
                ]
            ],
            "prompt" => [
                [
                    "id" => 2759,
                    "style_model_id" => 1,
                    "prompt" => "淡蓝色长发女孩 "
                ],
            ]
        ]);

        $service->allows()->create(\Mockery::any())->andReturn([
            "draw_id" => 809,
            "status" => 1,
            "expected_second" => '10'
        ]);

        $service->allows()->getCost(\Mockery::any())->andReturn([
            "total_basic_integral" => 809,
            "total_proportion_integral" => 101,
            "total_integral" => 1108,
        ]);

        $service->allows()->show(\Mockery::any(), \Mockery::any())->andReturn([
            'id' => '1',
            'url' => 'https://cdn.gpt-link.com/GPT/dev/wj_style_model/example_pic/model_1.png',
            'draw_id' => '1',
            'status' => '1',
            'created_at' => '2022-06-05 10:00:00',
            'type' => '1',
            'size' => '160*400',
            'proportion' => '1:5',
            'init_image_url' => 'https://cdn.gpt-link.com/GPT/dev/wj_style_model/example_pic/model_2.png',
        ]);

        $service->allows()->getDrawlists(\Mockery::any())->andReturn([
            [
                'id' => '1',
                'url' => 'https://cdn.gpt-link.com/GPT/dev/wj_style_model/example_pic/model_1.png',
                'draw_id' => '1',
                'status' => '1',
                'created_at' => '2022-06-05 10:00:00',
                'type' => '1',
                'size' => '160*400',
                'proportion' => '1:5',
                'init_image_url' => 'https://cdn.gpt-link.com/GPT/dev/wj_style_model/example_pic/model_2.png',
            ]
        ]);

        app()->set(DevelopService::class, $service);
    }
}
