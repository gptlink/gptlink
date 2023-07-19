<?php

namespace App\Model\Repository;

use App\Http\Dto\ChatGptModelDto;
use App\Model\ChatGptModel;
use App\Model\ChatGptModelCount;

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
     * 删除模型
     *
     * @throws \Exception
     */
    public function destroyModel()
    {
        ChatGptModelCount::query()->where('chat_gpt_model_id', $this->id)->delete();

        $this->delete();
    }

    /**
     * 排序
     *
     * @param int $sort
     * @return \App\Model\ChatGptModelRecord|ChatGptModel
     */
    public function updateSort(int $sort)
    {
        $this->update(['sort' => $sort]);
        return $this->refresh();
    }
}
