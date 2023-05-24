<?php

namespace App\Http\Control\Admin;

use App\Http\Resource\Admin\TaskRecordCollection;
use App\Model\TaskRecord;
use Cblink\HyperfExt\BaseController;

class TaskRecordController extends BaseController
{
    /**
     * 任务完成记录
     *
     * @return TaskRecordCollection
     */
    public function index()
    {
        $tasks = TaskRecord::query()
            ->search([
				'nickname' => ['type' => 'keyword', 'field' => 'nickname', 'relate' => 'member'],
				'mobile' => ['type' => 'keyword', 'field' => 'mobile', 'relate' => 'member'],
                'user_id' => ['type' => 'eq'],
                'type' => ['type' => 'eq'],
                'created_at' => ['type' => 'date'],
                'task_id' => ['type' => 'eq'],
            ])
			->whenWith([
				'member' => ['member:id,nickname,mobile']
			])
            ->select(['id', 'task_id', 'user_id', 'type', 'package_name', 'expired_day', 'num', 'created_at'])
            ->orderByDesc('created_at')
            ->page();

        return new TaskRecordCollection($tasks);
    }

}
