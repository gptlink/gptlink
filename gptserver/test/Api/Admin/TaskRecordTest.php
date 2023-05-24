<?php

namespace HyperfTest\Api\Admin;

use App\Model\Task;
use HyperfTest\Factory\TaskFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class TaskRecordTest extends TestCase
{
    use LoginTrait;

    public function testAdminTaskRecordIndex()
    {
        $this->AdminLogin();
        $userId = 1;
        /** @var Task $task */
        $task = TaskFactory::createRecordByData(Task::TYPE_SHARE, ['user_id' => $userId]);
        $response = $this->get('/admin/task/record', [
			'with_query' => ['member'],
			'nickname' => 'xiao',
			'mobile' => '13200001111',
            'created_at' => null,
			'type'=>''
        ]);

        TaskFactory::deleteByModel($task);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '任务完成记录列表',
            'category' => '任务管理',
            'params' => [],
            'desc' => '',
            'request' => [
				'with_query' => 'array：数组 member 用户信息',
				'nickname' => '昵称搜索',
                'created_at' => '时间',
                'type' => '任务事件类型'
            ],
            'request_except' => ['with_query','nickname','created_at','type'],
            'response' => [
                '*.id' => 'id',
                '*.task_id'=>'任务 id',
                '*.trade_no' => '订单编号',
                '*.user_id' => '用户 id',
                '*.type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                '*.package_name' => '套餐名称',
                '*.expired_day' => '增加天数',
                '*.num' => '增加的次数',
                '*.created_at' => '创建时间',
                '*.user' => '用户信息',
                '*.user.nickname' => '昵称',
                '*.user.mobile' => '手机号',
            ],
        ]));
    }

}
