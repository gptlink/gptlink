<?php

namespace HyperfTest\Api;

use App\Model\ChatGptModel;
use HyperfTest\Factory\ChatGptModelFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class ChatGptModelTest extends TestCase
{
    use LoginTrait;

    public function testWebChatGptModelIndex()
    {
        $chatGptModel = ChatGptModelFactory::createByData();

		$user = $this->userLogin(); // 可选 未登录也可以访问 只是获取不到用户的收藏信息

        $response = $this->get('/chat-gpt-model', [
			'platform' => ChatGptModel::PLATFORM_GPT,
			'with_query' => [],
			'keyword' => '',
			'is_all'=> false
		]);

        $this->assertApiSuccess($response);
        ChatGptModelFactory::deleteById($chatGptModel->id);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '模型列表',
            'category' => '模型相关',
            'params' => [],
            'desc' => '【登录和未登录都可访问，未登录时，不返回用户收藏信息】',
            'request' => [
				'is_all'=>'是否获取全部模型 传true获取全部模型默认最大为500条 不传获取分页数据 【GPT(非魔法书)使用这个接口使用true传参】',
				'platform'=> BaseDto::mapDesc('平台类型【必传】', ChatGptModel::PLATFORM),
				'keyword'=> '关键词搜索',
			],
            'request_except' => [],
            'response' => [
				'*.id' => 'id',
				'*.user_id' => '用户 id 没有说明是平台创建',
				'*.icon' => 'icon',
				'*.name' => '模型名称',
				'*.prompt' => '开场语',
				'*.status' => BaseDto::mapDesc('状态:', ChatGptModel::STATUS),
				'*.sort' => '排序',
				'*.uses' => '使用次数',
				'*.source' => BaseDto::mapDesc('来源', ChatGptModel::SOURCE),
				'*.desc' => '描述',
				'*.type' => BaseDto::mapDesc('类型', ChatGptModel::TYPE),
            ],
        ]));
    }
}
