<?php

namespace App\Http\Control\Web;

use App\Http\Request\Web\TaskCompletionRequest;
use App\Http\Resource\TaskCollection;
use App\Http\Resource\TaskRecordResource;
use App\Http\Resource\TaskResource;
use App\Model\Task;
use App\Model\TaskRecord;
use Cblink\HyperfExt\BaseController;

class TaskController extends BaseController
{
    /**
     * 任务中心列表
     *
     * @return TaskCollection
     */
    public function index()
    {
        $tasks = Task::query()
            ->where(['status' => Task::STATUS_ON])
            ->with([
                'package:id,name,expired_day,num',
                'record' => function ($query) {
                    $query->where(['user_id' => auth()->id()]);
                }
            ])
            ->get(['id', 'type', 'title', 'desc', 'status', 'platform', 'share_image', 'rule', 'package_id']);

        return new TaskCollection($tasks);
    }

    /**
     * 完成任务
     *
     * @param TaskCompletionRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function completion(TaskCompletionRequest $request)
    {
        // 处理完成
        if (!in_array($request->input('type'), [Task::TYPE_SHARE])) {
            $this->success(['result' => false]);
        }
        $result = Task::completion($request->input('type'), auth()->id());
        return $this->success(['result' => $result]);
    }

    /**
     * 验证任务是否完成
     *
     * @param TaskCompletionRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function checkTask(TaskCompletionRequest $request)
    {
        // 处理完成
        /** @var Task $task */
        $task = Task::query()->where([
            'type' => $request->input('type'),
            'status' => Task::STATUS_ON
        ])->first();
        if (!$task) {
            return $this->success(['result' => false]);
        }
        $result = $task->checkCompleted($task->type, auth()->id());
        return $this->success(['result' => $result]);
    }

    /**
     * 查询未读的任务
     *
     * @param TaskCompletionRequest $request
     * @return TaskResource|\Psr\Http\Message\ResponseInterface
     */
    public function getRecordUnread(TaskCompletionRequest $request)
    {
        $type = $request->input('type');
        $task = Task::query()->withCount(['record' => function($query) use ($type) {
            $query->where(['user_id' => auth()->id(), 'is_read' => TaskRecord::IS_READ_N]);
        }])->where(['type' => $type])->with(['package'])->first();
        if (!$task->record_count) {
            return $this->success();
        }

        return new TaskResource($task);
    }


    /**
     * 修改已读
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updateRecordRead($type)
    {
        TaskRecord::query()->where([
            'type' => $type,
            'user_id' => auth()->id(),
        ])->update(['is_read' => TaskRecord::IS_READ_Y]);

        return $this->success();
    }
}
