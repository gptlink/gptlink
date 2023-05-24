<?php

namespace App\Model\Repository;

use App\Http\Dto\ChatLogDto;
use App\Model\ChatLog;

trait ChatLogTrait
{
    /**
     * @param \App\Http\Dto\ChatLogDto $dto
     *
     * @return \App\Model\ChatLog|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createByDto(ChatLogDto $dto)
    {
        return ChatLog::query()->create($dto->toData());
    }
}
