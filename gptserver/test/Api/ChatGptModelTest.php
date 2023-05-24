<?php

namespace HyperfTest\Api;

use App\Exception\ErrCode;
use App\Exception\FailReturnException;
use App\Http\Service\TencentCloudTmsService;
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
			'platform' => ChatGptModel::PLATFORM_MAGIC,
			'with_query' => ['member', 'collect'],
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
				'with_query' => '关联用户: member，关联收藏: collect',
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
				'*.member' => '用户信息 如果是平台创建的模型则没有用户信息 返回为null',
				'*.member.id' => '用户id',
				'*.member.nickname' => '用户昵称',
				'*.member.avatar' => '用户头像',
				'*.collect' => '用户收藏 如果没有收藏 返回为null',
				'*.collect.id' => '收藏id',
				'*.collect.member_id' => '用户id',
				'*.collect.chat_gpt_model_id' => '模型id',
            ],
        ]));
    }

    public function testWebChatGptModelShow()
    {
        $chatGptModel = ChatGptModelFactory::createByData();

        $response = $this->get(sprintf('/chat-gpt-model/%s', $chatGptModel->id));

        $this->assertApiSuccess($response);
        ChatGptModelFactory::deleteById($chatGptModel->id);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '模型详情',
            'category' => '模型相关',
            'params' => [
                2 => 'id'
            ],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'user_id' => '用户 id 没有说明是平台创建',
                'icon' => 'icon',
                'name' => '模型名称',
                'prompt' => '开场语',
                'status' => BaseDto::mapDesc('状态:', ChatGptModel::STATUS),
                'sort' => '排序',
            ],
        ]));
    }
}
