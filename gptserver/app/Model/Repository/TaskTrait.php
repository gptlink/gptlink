<?php

namespace App\Model\Repository;

use App\Event\TaskRecordEvent;
use App\Http\Dto\TaskDto;
use App\Model\Task;
use App\Model\TaskRecord;
use Carbon\Carbon;
use Hyperf\Utils\Arr;

trait TaskTrait
{
    /**
     * @param TaskDto $dto
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createByDto(TaskDto $dto)
    {
        return Task::query()->updateOrCreate($dto->whereByType(), $dto->getFillableData());
    }

    /**
     * @param int $status
     * @return Task
     */
    public function updateStatus(int $status)
    {
        $this->update(['status' => $status]);
        return $this->refresh();
    }

    /**
     * 触发任务
     *
     * @param string $type
     * @param int $userId
     * @param mixed $skipCheck
     * @return bool
     */
    public static function completion(string $type, int $userId, $skipCheck = false)
    {
        /** @var Task $task */
        $task = Task::query()->where([
            'type' => $type,
            'status' => Task::STATUS_ON,
        ])->with(['package'])->first();
        if (! $task || ! Arr::get($task, 'package')) {
            return false;
        }
        $checkRes = $task->checkCompleted($type, $userId);
        // 2. 查询对应任务触发发送任务
        if (! $checkRes || $skipCheck) {
            event(new TaskRecordEvent($task, $userId));
            return true;
        }
        return $checkRes;
    }

    /**
     * 验证任务完成
     *
     * @param $userId
     * @param mixed $type
     * @return bool
     */
    public function checkCompleted($type, $userId)
    {
        // 查询
        $query = TaskRecord::query()->where(['user_id' => $userId, 'type' => $type]);
        // 1. 判断任务规则是一次性还是可以无限次使用
        if (Arr::get($this->rule, 'frequency') == 1) {
            switch (Arr::get($this->rule, 'valid_type')) {
                case Task::RULE_VALID_TYPE_EVERYDAY:
                    $query->whereDate('created_at', Carbon::now()->toDateString());
                    break;
            }
            $checkRes = $query->exists();
        } else {
            $checkRes = $query->exists();
        }
        return $checkRes;
    }
}
