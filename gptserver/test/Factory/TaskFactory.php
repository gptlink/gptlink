<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Http\Dto\ChatGptModelDto;
use App\Http\Dto\TaskDto;
use App\Http\Dto\TaskRecordDto;
use App\Model\ChatGptModel;
use App\Model\Package;
use App\Model\Task;
use App\Model\TaskRecord;
use Hyperf\Utils\Arr;

class TaskFactory
{
    public static function createByData($type, array $payload = [])
    {
        $package = PackageFactory::createByData();

        return Task::createByDto(new TaskDto(array_merge([
            'title' => 'title',
            'desc' => 'desc',
            'platform' => [Task::PLATFORM_H5],
            'share_image' => 'share_image.png',
            'rule' => Task::RULE[$type],
            'package_id' => $package->id,
            'type' => $type
        ], $payload)));
    }

    /**
     * 记录
     *
     * @param $type
     * @param array $payload
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createRecordByData($type, array $payload = [])
    {
        $task = self::createByData($type, $payload);
        TaskRecord::createByDto(new TaskRecordDto(array_merge([
            'user_id' => 1,
            'task_id' => $task->id,
            'type' => $type,
            'package_name' => 'test',
            'expired_day' => 10,
            'num' => 10,
        ], $payload)));

        return $task;
    }

    public static function deleteByModel(Task $task)
    {
        Task::query()->where('id', $task->id)->delete();
        TaskRecord::query()->where('task_id', $task->id)->delete();
        Package::query()->where('id', $task->package_id)->delete();
    }

    public static function deleteById($taskId)
    {
        Task::query()->where('id', $taskId)->delete();
    }
}
