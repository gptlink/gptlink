<?php

namespace App\Model\Repository;

use App\Http\Dto\PromptDto;
use App\Model\Prompt;
use App\Model\PromptCount;

trait PromptTrait
{
    /**
     * @param PromptDto $dto
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createByDto(PromptDto $dto)
    {
        $prompt = Prompt::query()->create($dto->getFillableData());
        PromptCount::query()->create(['prompt_id' => $prompt->id]);
        return $prompt;
    }

    /**
     * @param PromptDto $dto
     * @return Prompt
     */
    public function updateByDto(PromptDto $dto)
    {
        $this->update($dto->getUpdateData());
        return $this->refresh();
    }

    /**
     * @param int $status
     * @return Prompt
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
        PromptCount::query()->where('prompt_id', $this->id)->delete();

        $this->delete();
    }

    /**
     * 排序
     *
     * @param int $sort
     * @return Prompt
     */
    public function updateSort(int $sort)
    {
        $this->update(['sort' => $sort]);
        return $this->refresh();
    }
}
