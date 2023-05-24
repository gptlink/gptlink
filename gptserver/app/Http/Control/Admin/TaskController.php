<?php

namespace App\Http\Control\Admin;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\TaskDto;
use App\Http\Request\Admin\TaskStoreRequest;
use App\Http\Resource\Admin\TaskCollection;
use App\Http\Resource\Admin\TaskResource;
use App\Model\Task;
use Cblink\HyperfExt\BaseController;

class TaskController extends BaseController
{
    public function index()
    {
        $tasks = Task::query()->get(['id', 'type', 'title', 'status']);

        return new TaskCollection($tasks);
    }

    /**
     * @param $type
     * @return TaskResource|\Psr\Http\Message\ResponseInterface
     */
    public function show($type)
    {
        $task = Task::query()->where(['type' => $type])
            ->with('package:id,name')
            ->first();
        if(!$task){
            return $this->success();
        }

        return new TaskResource($task);
    }

    /**
     * 新增
     *
     * @param $type
     * @param TaskStoreRequest $request
     * @return TaskResource
     */
    public function store($type, TaskStoreRequest $request)
    {
        $task = Task::createByDto(new TaskDto(array_merge($request->validated(), [
            'type' => $type
        ])));

        return new TaskResource($task);
    }

    /**
     * 编辑状态
     *
     * @param $type
     * @return TaskResource
     */
    public function updateStatus($type)
    {
        /** @var Task $task */
        $task = Task::query()->where(['type' => $type])->first();
        throw_unless($task, LogicException::class, ErrCode::TASK_ONT_FOUND_UPDATE_STATUS);
        $status = $task->status == Task::STATUS_ON ? Task::STATUS_OFF: Task::STATUS_ON;
        return new TaskResource($task->updateStatus($status));

    }

}
