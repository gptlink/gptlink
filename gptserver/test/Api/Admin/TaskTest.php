<?php

namespace HyperfTest\Api\Admin;

use App\Model\Package;
use App\Model\Task;
use Hyperf\Utils\Arr;
use HyperfTest\Factory\PackageFactory;
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

    public function testAdminTaskIndex()
    {
        $this->AdminLogin();
        /** @var Task $task */
        $task = TaskFactory::createByData(Task::TYPE_SHARE);
        $response = $this->get('/admin/task');

        TaskFactory::deleteByModel($task);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '任务列表',
            'category' => '任务管理',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => 'id',
                '*.type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                '*.title' => '标题',
                '*.status' => BaseDto::mapDesc('状态:', Task::STATUS)
            ],
        ]));
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testAdminTaskRegisterShow()
    {
        $this->AdminLogin();
        /** @var Task $task */
        $task = TaskFactory::createByData(Task::TYPE_REGISTER);
        $response = $this->get(sprintf('/admin/task/%s', $task->type));
        $response->dump();
        TaskFactory::deleteByModel($task);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '注册任务详情',
            'category' => '任务管理',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'title' => '标题',
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'desc' => '描述',
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'share_image' => '分享图/背景图',
                'rule' => '规则',
                'rule.frequency' => '发送次数0 代表无限',
                'package_id' => '套餐 id',
                'package' => '套餐信息',
                'package.id' => '套餐 id',
                'package.name' => '套餐名称'
            ],
        ]));
    }

    public function testAdminTaskInviteShow()
    {
        $this->AdminLogin();
        /** @var Task $task */
        $task = TaskFactory::createByData(Task::TYPE_INVITE);
        $response = $this->get(sprintf('/admin/task/%s', $task->type));
        $response->dump();
        TaskFactory::deleteByModel($task);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '邀请任务详情',
            'category' => '任务管理',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'title' => '标题',
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'desc' => '描述',
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'share_image' => '分享图/背景图',
                'rule' => '规则',
                'rule.frequency' => '发送次数0 代表无限',
                'package_id' => '套餐 id',
                'package' => '套餐信息',
                'package.id' => '套餐 id',
                'package.name' => '套餐名称'
            ],
        ]));
    }

    public function testAdminTaskShareShow()
    {
        $this->AdminLogin();
        /** @var Task $task */
        $task = TaskFactory::createByData(Task::TYPE_SHARE);
        $response = $this->get(sprintf('/admin/task/%s', $task->type));
        TaskFactory::deleteByModel($task);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '分享任务详情',
            'category' => '任务管理',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'title' => '标题',
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'desc' => '描述',
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'share_image' => '分享图/背景图',
                'rule' => '规则',
                'rule.frequency' => '发送次数0 代表无限',
                'package_id' => '套餐 id',
                'package' => '套餐信息',
                'package.id' => '套餐 id',
                'package.name' => '套餐名称'
            ],
        ]));
    }


    public function testAdminTaskRegisterStore()
    {
        $this->AdminLogin();

        $package = PackageFactory::createByData();
        $response = $this->post('/admin/task/register', [
            'type' => Task::TYPE_REGISTER,
            'platform' => Task::PLATFORM_H5,
            'status' => Task::STATUS_ON,
            'package_id' => $package->id
        ]);
        TaskFactory::deleteById(Arr::get($response->response(), 'data.id'));
        PackageFactory::deleteById($package->id);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存注册任务',
            'category' => '任务管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'package_id' => '套餐 id'
            ],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'title' => '标题',
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'desc' => '描述',
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'share_image' => '分享图/背景图',
                'rule' => '规则',
                'rule.frequency' => '发送次数0 代表无限',
                'package_id' => '套餐 id',
                'package' => '套餐信息',
                'package.id' => '套餐 id',
                'package.name' => '套餐名称'
            ],
        ]));
    }

    // 邀请保存
    public function testAdminTaskInviteStore()
    {
        $this->AdminLogin();

        $package = PackageFactory::createByData();
        $response = $this->post('/admin/task/invite', [
            'type' => Task::TYPE_INVITE,
            'title' => 'test',
            'desc' => 'test',
            'platform' => Task::PLATFORM_H5,
            'share_image' => 'image.png',
            'status' => Task::STATUS_ON,
            'package_id' => $package->id
        ]);

        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存邀请任务',
            'category' => '任务管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'package_id' => '套餐 id',
                'title' => '标题',
                'desc' => '描述',
                'share_image' => '图片',
            ],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'title' => '标题',
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'desc' => '描述',
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'share_image' => '分享图/背景图',
                'rule' => '规则',
                'rule.frequency' => '发送次数0 代表无限',
                'package_id' => '套餐 id',
                'package' => '套餐信息',
                'package.id' => '套餐 id',
                'package.name' => '套餐名称'
            ],
        ]));
    }

    // 分享新增
    public function testAdminTaskShareStore()
    {
        $this->AdminLogin();
        $package = PackageFactory::createByData();
        $response = $this->post('/admin/task/share', [
            'type' => Task::TYPE_SHARE,
            'title' => 'test',
            'desc' => 'test',
            'platform' => Task::PLATFORM_H5,
            'share_image' => 'image.png',
            'status' => Task::STATUS_ON,
            'rule' => [],
            'package_id' => $package->id
        ]);
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '保存分享任务',
            'category' => '任务管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'package_id' => '套餐 id',
                'title' => '标题',
                'desc' => '描述',
                'share_image' => '图片',
            ],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'title' => '标题',
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'desc' => '描述',
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'share_image' => '分享图/背景图',
                'rule' => '规则',
                'rule.frequency' => '发送次数0 代表无限',
                'package_id' => '套餐 id',
                'package' => '套餐信息',
                'package.id' => '套餐 id',
                'package.name' => '套餐名称'
            ],
        ]));
    }

    public function testAdminTaskShareUpdateStatus()
    {
        $this->AdminLogin();
        /** @var Task $task */
        $task = TaskFactory::createByData(Task::TYPE_REGISTER);
        $response = $this->put('/admin/task/share/status');
        TaskFactory::deleteByModel($task);
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '任务状态变更',
            'category' => '任务管理',
            'params' => [
                3 => BaseDto::mapDesc('任务类型:', Task::TYPE),
            ],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'type' => BaseDto::mapDesc('任务类型:', Task::TYPE),
                'title' => '标题',
                'status' => BaseDto::mapDesc('状态:', Task::STATUS),
                'desc' => '描述',
                'platform' => BaseDto::mapDesc('状态:', Task::PLATFORM),
                'share_image' => '分享图/背景图',
                'rule' => '规则',
                'rule.frequency' => '发送次数0 代表无限',
                'package_id' => '套餐 id',
                'package' => '套餐信息',
                'package.id' => '套餐 id',
                'package.name' => '套餐名称'
            ],
        ]));
    }

}
