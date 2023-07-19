<?php

namespace App\Model\Repository;

use App\Http\Dto\TaskRecordDto;
use App\Model\TaskRecord;

trait TaskRecordTrait
{
    /**
     * @param TaskRecordDto $dto
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createByDto(TaskRecordDto $dto)
    {
        return TaskRecord::query()->create($dto->getFillableData());
    }

    /**
     * @param $isRead
     * @return TaskRecord
     */
    public function updateIsRead($isRead)
    {
        $this->update(['is_read' => $isRead]);
        return $this->refresh();
    }
}
