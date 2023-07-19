<?php

namespace App\Listener\Task;

use App\Event\TaskRecordEvent;
use App\Http\Dto\TaskRecordDto;
use App\Model\MemberPackage;
use App\Model\Package;
use App\Model\Task;
use App\Model\TaskRecord;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Utils\Arr;

/**
 * 所有任务完成触发
 */
class TaskRecordListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            TaskRecordEvent::class,
        ];
    }

    /**
     * @param TaskRecordEvent $event
     */
    public function process(object $event)
    {
        /** @var Task $task */
        $task = $event->task;
        $userId = $event->userId;
        // 完成任务发送奖励
        /** @var Package $package */
        $package = $task->package;
        $package->sendToUser($userId, MemberPackage::CHANNEL_TASK);
        // 完成任务记录
        $res1 = TaskRecord::createByDto(new TaskRecordDto([
            'user_id' => $userId,
            'task_id' => $task->id,
            'type' => $task->type,
            'package_name' => Arr::get($task->package, 'name'),
            'expired_day' => Arr::get($task->package, 'expired_day'),
            'num' => Arr::get($task->package, 'num'),
        ]));
    }
}
