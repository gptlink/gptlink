<?php

namespace App\Event;

use App\Model\Task;

class TaskRecordEvent
{
    /**
     * @var Task
     */
    public $task;

    public $userId;

    public function __construct(Task $task, int $userId)
    {
        $this->task = $task;
        $this->userId = $userId;
    }
}
