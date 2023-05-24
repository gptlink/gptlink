<?php

namespace App\Model\Repository;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\ChatGptModelDto;
use App\Http\Dto\ChatGptModelRecordDto;
use App\Model\ChatGptModel;
use App\Model\ChatGptModelCount;
use App\Model\ChatGptModelRecord;
use App\Model\GptModelCollect;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\Arr;

trait ChatGptModelTrait
{
    /**
     * @param ChatGptModelDto $dto
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createByDto(ChatGptModelDto $dto)
    {
        $chatGptModel = ChatGptModel::query()->create($dto->getFillableData());
        ChatGptModelCount::query()->create(['chat_gpt_model_id' => $chatGptModel->id]);
        return $chatGptModel;
    }

    /**
     * @param ChatGptModelDto $dto
     * @return ChatGptModel
     */
    public function updateByDto(ChatGptModelDto $dto)
    {
        $this->update($dto->getUpdateData());
        return $this->refresh();
    }

    /**
     * @param int $status
     * @return ChatGptModel
     */
    public function updateStatus(int $status)
    {
        $this->update(['status' => $status]);
        return $this->refresh();
    }

    /**
     * 排序
     *
     * @param int $sort
     * @return ChatGptModel|\App\Model\ChatGptModelRecord
     */
    public function updateSort(int $sort)
    {
        $this->update(['sort' => $sort]);
        return $this->refresh();
    }
}
