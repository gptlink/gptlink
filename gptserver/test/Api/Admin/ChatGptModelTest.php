<?php

namespace HyperfTest\Api\Admin;

use App\Model\ChatGptModel;
use Cblink\Hyperf\Yapi\Dto;
use Hyperf\Utils\Arr;
use HyperfTest\Factory\ChatGptModelFactory;
use HyperfTest\Factory\MemberFactory;
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

    public function testAdminChatGptModelIndex()
    {
        $this->AdminLogin();
        $member = MemberFactory::createByData();

        $chatGptModel = ChatGptModelFactory::createByData([
            'platform' => ChatGptModel::PLATFORM_GPT,
            'user_id' => $member->id,
            'source' => ChatGptModel::SOURCE_PLATFORM,
        ]);

        $response = $this->get('/admin/chat-gpt-model', [
            'name' => null,
            'platform' => ChatGptModel::PLATFORM_GPT,
            'source' => null,
            'type' => null,
            'status' => null,
            'nickname' => null,
            'mobile' => null,
            'with_query' => ['member', 'count_data']
        ]);

        $this->assertApiSuccess($response);
        ChatGptModelFactory::deleteById($chatGptModel->id);
        $member->delete();
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '模型列表',
            'category' => '模型管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'name' => '模型名称',
                'platform' => Dto::mapDesc('平台:', ChatGptModel::PLATFORM),
                'source' => Dto::mapDesc('来源:', ChatGptModel::SOURCE),
                'type' => Dto::mapDesc('类型:', ChatGptModel::TYPE),
                'status' => Dto::mapDesc('状态:', ChatGptModel::STATUS),
                'nickname' => '用户昵称',
                'mobile' => '手机号',
                'with_query' => 'with_query[]=member标识用户信息,魔法书时需要传递;count_data统计值(点赞,使用量)'
            ],
            'request_except' => [
                'name', 'platform', 'source', 'type', 'status', 'nickname', 'mobile'
            ],
            'response' => [
                '*.id' => 'id',
                '*.user_id' => '用户 id 没有说明是平台创建',
                '*.icon' => 'icon',
                '*.name' => '模型名称',
                '*.prompt' => '开场语',
                '*.system' => '咒语',
                '*.status' => BaseDto::mapDesc('状态:', ChatGptModel::STATUS),
                '*.source' => Dto::mapDesc('来源:', ChatGptModel::SOURCE),
                '*.type' => Dto::mapDesc('类型:', ChatGptModel::TYPE),
                '*.sort' => '排序0 说明没有开启置顶',
                '*.desc' => '描述',
                '*.likes' => '点赞量',
                '*.uses' => '使用量',
                '*.nickname' => '用户昵称',
                '*.mobile' => '用户手机号'
            ],
        ]));
    }

    public function testAdminChatGptModelShow()
    {
        $this->AdminLogin();
        $chatGptModel = ChatGptModelFactory::createByData();

        $response = $this->get(sprintf('/admin/chat-gpt-model/%s', $chatGptModel->id));
        $this->assertApiSuccess($response);
        $chatGptModel->delete();
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '模型详情',
            'category' => '模型管理',
            'params' => [3 => '模型 id'],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'user_id' => '用户 id 没有说明是平台创建',
                'icon' => 'icon',
                'name' => '模型名称',
                'prompt' => '开场语',
                'system' => '咒语',
                'status' => BaseDto::mapDesc('状态:', ChatGptModel::STATUS),
                'sort' => '排序',
                'platform' => Dto::mapDesc('平台:', ChatGptModel::PLATFORM),
                'desc' => '描述',
                'remark' => '备注',
                'type' => Dto::mapDesc('类型:', ChatGptModel::TYPE),
            ],
        ]));
    }

    // 创建套餐
    public function testAdminChatGptModelStore()
    {
        $this->AdminLogin();

        $response = $this->post('/admin/chat-gpt-model', [
            'icon' => '#33#333',
            'name' => 'name-test',
            'prompt' => 'prompt-test',
            'system' => 'system-test',
            'sort' => 1,
            'platform' => ChatGptModel::PLATFORM_GPT,
            'desc' => 'test',
            'remark' => '备注',
            'type' => ChatGptModel::TYPE_DIALOGUE,
        ]);
        $this->assertApiSuccess($response);
        ChatGptModelFactory::deleteById(Arr::get($response->response(), 'data.id'));
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '新增套餐',
            'category' => '模型管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'icon' => 'icon',
                'name' => '模型名称',
                'prompt' => '开场语',
                'system' => '咒语',
                'sort' => '排序',
                'platform' => Dto::mapDesc('平台',ChatGptModel::PLATFORM),
                'desc' => 'test',
                'remark' => '备注',
                'type' => Dto::mapDesc('类型',ChatGptModel::TYPE),
            ],
            'request_except' => ['desc', 'remark'],
            'response' => [
                'id' => 'id',
                'user_id' => '用户 id 没有说明是平台创建',
                'icon' => 'icon',
                'name' => '模型名称',
                'prompt' => '开场语',
                'system' => '咒语',
                'status' => BaseDto::mapDesc('状态:', ChatGptModel::STATUS),
                'sort' => '排序',
                'platform' => Dto::mapDesc('平台:', ChatGptModel::PLATFORM),
                'desc' => '描述',
                'remark' => '备注',
                'type' => Dto::mapDesc('类型:', ChatGptModel::TYPE),
            ],
        ]));
    }

    // 编辑
    public function testAdminChatGptModelUpdate()
    {
        $this->AdminLogin();
        $chatGptModel = ChatGptModelFactory::createByData();
        $response = $this->put(sprintf('/admin/chat-gpt-model/%s', $chatGptModel->id), [
            'icon' => '#33#333',
            'name' => 'name-test',
            'prompt' => 'prompt-test',
            'system' => 'system-test',
            'sort' => 1,
            'desc' => 'test',
            'remark' => '备注',
            'type' => ChatGptModel::TYPE_DIALOGUE,
            'platform' => ChatGptModel::PLATFORM_GPT
        ]);

        $this->assertApiSuccess($response);
        ChatGptModelFactory::deleteById($chatGptModel->id);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '编辑模型',
            'category' => '模型管理',
            'params' => [3 => '模型 id'],
            'desc' => '',
            'request' => [
                'icon' => 'icon',
                'name' => '模型名称',
                'prompt' => '开场语',
                'system' => '咒语',
                'sort' => '排序',
                'desc' => 'test',
                'remark' => '备注',
                'type' => Dto::mapDesc('类型',ChatGptModel::TYPE),
            ],
            'request_except' => ['desc', 'remark'],
            'response' => [
                'id' => 'id',
                'user_id' => '用户 id 没有说明是平台创建',
                'icon' => 'icon',
                'name' => '模型名称',
                'prompt' => '开场语',
                'system' => '咒语',
                'status' => BaseDto::mapDesc('状态:', ChatGptModel::STATUS),
                'sort' => '排序',
                'platform' => Dto::mapDesc('平台:', ChatGptModel::PLATFORM),
                'desc' => '描述',
                'remark' => '备注',
                'type' => Dto::mapDesc('类型:', ChatGptModel::TYPE),
            ],
        ]));
    }

    // 编辑是否展示
    public function testAdminChatGptModelStatus()
    {
        $this->AdminLogin();
        $chatGptModel = ChatGptModelFactory::createByData();
        $response = $this->put(sprintf('/admin/chat-gpt-model/%s/status', $chatGptModel->id), [
            'status' => ChatGptModel::STATUS_ON
        ]);
        $this->assertApiSuccess($response);
        ChatGptModelFactory::deleteById($chatGptModel->id);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '编辑模型状态',
            'category' => '模型管理',
            'params' => [3 => '模型 id'],
            'desc' => '',
            'request' => ['status' => Dto::mapDesc('状态:', ChatGptModel::STATUS)],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'user_id' => '用户 id 没有说明是平台创建',
                'icon' => 'icon',
                'name' => '模型名称',
                'prompt' => '开场语',
                'system' => '咒语',
                'status' => BaseDto::mapDesc('状态:', ChatGptModel::STATUS),
                'sort' => '排序',
                'platform' => Dto::mapDesc('平台:', ChatGptModel::PLATFORM),
                'desc' => '描述',
                'remark' => '备注',
                'type' => Dto::mapDesc('类型:', ChatGptModel::TYPE),
            ],
        ]));
    }
    // 置顶
    public function testAdminChatGptModelTop()
    {
        $this->AdminLogin();
        $chatGptModel = ChatGptModelFactory::createByData();
        $response = $this->post(sprintf('/admin/chat-gpt-model/%s/top', $chatGptModel->id));

        $this->assertApiSuccess($response);
        ChatGptModelFactory::deleteById($chatGptModel->id);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '模型置顶',
            'category' => '模型管理',
            'params' => [3 => '模型 id'],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'user_id' => '用户 id 没有说明是平台创建',
                'icon' => 'icon',
                'name' => '模型名称',
                'prompt' => '开场语',
                'system' => '咒语',
                'status' => BaseDto::mapDesc('状态:', ChatGptModel::STATUS),
                'sort' => '排序',
                'platform' => Dto::mapDesc('平台:', ChatGptModel::PLATFORM),
                'desc' => '描述',
                'remark' => '备注',
                'type' => Dto::mapDesc('类型:', ChatGptModel::TYPE),
            ],
        ]));
    }

    public function testAdminChatGptModelCancelTop()
    {
        $this->AdminLogin();
        $chatGptModel = ChatGptModelFactory::createByData();
        $response = $this->post(sprintf('/admin/chat-gpt-model/%s/cancel-top', $chatGptModel->id));

        $this->assertApiSuccess($response);
        ChatGptModelFactory::deleteById($chatGptModel->id);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '模型取消置顶',
            'category' => '模型管理',
            'params' => [3 => '模型 id'],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'user_id' => '用户 id 没有说明是平台创建',
                'icon' => 'icon',
                'name' => '模型名称',
                'prompt' => '开场语',
                'system' => '咒语',
                'status' => BaseDto::mapDesc('状态:', ChatGptModel::STATUS),
                'sort' => '排序',
                'platform' => Dto::mapDesc('平台:', ChatGptModel::PLATFORM),
                'desc' => '描述',
                'remark' => '备注',
                'type' => Dto::mapDesc('类型:', ChatGptModel::TYPE),
            ],
        ]));
    }

    public function testAdminChatGptModelDestroy()
    {
        $this->AdminLogin();

        $chatGptModel = ChatGptModelFactory::createByData();

        $response = $this->delete(sprintf('/admin/chat-gpt-model/%s', $chatGptModel->id));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '删除模型',
            'category' => '模型管理',
            'params' => [3 => '模型 id'],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [],
        ]));
    }
}
