<?php

namespace HyperfTest\Api;

use App\Model\Task;
use HyperfTest\Factory\TaskFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class TaskTest extends TestCase
{
    use LoginTrait;

    public function testWebTaskIndex()
    {
        $user = $this->userLogin();
        /** @var Task $task */
        $task = TaskFactory::createRecordByData(Task::TYPE_SHARE, ['user_id' => $user->id]);
        $task->updateStatus(Task::STATUS_ON);
        $response = $this->get('/task');
        TaskFactory::deleteByModel($task);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '任务列表',
            'category' => '任务相关',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => 'id',
                '*.type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                '*.title' => '标题',
                '*.status' => BaseDto::mapDesc('状态:', Task::STATUS),
                '*.desc' => '描述',
                '*.platform' => '平台',
                '*.share_image' => '分享图片',
                '*.rule' => '规则(前端暂时不用管)',
                '*.rule.frequency' => '触发次数 0 无限次',
                '*.rule.valid_type' => '时间规则',
                '*.package_id' => '套餐 id',
                '*.package' => '套餐',
                '*.package.name' => '套餐名称',
                '*.package.expired_day' => '增加天数',
                '*.package.num' => '增加测次数',
                '*.is_completed' => '任务是否已经完成 true 完成; false 没有完成',
            ],
        ]));
    }

    public function testWebTaskCompletion()
    {
        $user = $this->userLogin();
        /** @var Task $task */
        $task = TaskFactory::createByData(Task::TYPE_SHARE);
        $task->updateStatus(Task::STATUS_ON);
        $response = $this->post('/task/completion', [
            'type' => Task::TYPE_SHARE
        ]);
        TaskFactory::deleteByModel($task);
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '完成任务',
            'category' => '任务相关',
            'params' => [],
            'desc' => '',
            'request' => ['type' => BaseDto::mapDesc('任务类型:', Task::TYPE)],
            'request_except' => [],
            'response' => ['result' => '验证是否完成任务, true 完成;false 没有完成'],
        ]));
    }

    // 验证任务是否完成
    public function testWebTaskCheck()
    {
        $user = $this->userLogin();
        /** @var Task $task */
        $task = TaskFactory::createByData(Task::TYPE_SHARE);
        $task->updateStatus(Task::STATUS_ON);
        $response = $this->post('/task/check', [
            'type' => Task::TYPE_SHARE
        ]);
        TaskFactory::deleteByModel($task);
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '校验任务是否完成',
            'category' => '任务相关',
            'params' => [],
            'desc' => '',
            'request' => ['type' => BaseDto::mapDesc('任务类型:', Task::TYPE)],
            'request_except' => [],
            'response' => ['result' => '验证是否完成任务, true 完成;false 没有完成'],
        ]));
    }
    // 未读信息
    public function testWebTaskGetRecordUnread()
    {
        $user = $this->userLogin();
        /** @var Task $task */
        $task = TaskFactory::createRecordByData(Task::TYPE_SHARE, ['user_id' => $user->id]);
        $task->updateStatus(Task::STATUS_ON);
        $response = $this->get('/task/record/unread', [
            'type' => Task::TYPE_SHARE
        ]);
        TaskFactory::deleteByModel($task);
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '获取未读完的任务记录',
            'category' => '任务相关',
            'params' => [],
            'desc' => '',
            'request' => ['type' => BaseDto::mapDesc('任务类型:', Task::TYPE)],
            'request_except' => [],
            'response' => [
                'id' => '任务id',
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'package_name' => '套餐名称',
                'expired_day' => '天数',
                'num' => '次数',
                'record_count' => '总数',
            ],
        ]));
    }

    public function testWebTaskUpdateRecordRead()
    {
        $user = $this->userLogin();
        /** @var Task $task */
        $task = TaskFactory::createRecordByData(Task::TYPE_SHARE);
        $task->updateStatus(Task::STATUS_ON);
        $response = $this->put(sprintf('/task/record/%s/read', Task::TYPE_SHARE));
        TaskFactory::deleteByModel($task);
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '修改记录已读',
            'category' => '任务相关',
            'params' => [3 => 'type'],
            'desc' => '',
            'request' => ['type' => BaseDto::mapDesc('任务类型:', Task::TYPE)],
            'request_except' => [],
            'response' => [],
        ]));
    }

}
