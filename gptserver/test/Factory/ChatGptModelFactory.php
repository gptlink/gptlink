<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Http\Dto\ChatGptModelDto;
use App\Http\Dto\ChatGptModelRecordDto;
use App\Model\ChatGptModel;
use App\Model\ChatGptModelRecord;
use App\Model\GptModelCollect;

class ChatGptModelFactory
{
    public static function createByData(array $payload = [])
    {
        return ChatGptModel::createByDto(new ChatGptModelDto(array_merge([
            'icon' => '#33#333',
            'name' => 'name-test',
            'prompt' => 'prompt-test',
            'system' => 'system-test',
            'status' => ChatGptModel::STATUS_ON,
            'sort' => 1,
            'platform' => ChatGptModel::PLATFORM_MAGIC,
            'desc' => 'test',
            'remark' => 'test',
            'source' => ChatGptModel::SOURCE_MAGIC,
            'type' => ChatGptModel::TYPE_QUESTION,
            'user_id' => 0
        ], $payload)));
    }

    /**
     * @param ChatGptModel $chatGptModel
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createRecord(ChatGptModel $chatGptModel)
    {
        return ChatGptModelRecord::createByDto(new ChatGptModelRecordDto([
            'chat_gpt_model_id' => $chatGptModel->id,
            'label' => 'Porn,Abuse',
            'trigger' => 'XXX,XXX,XXX',
        ]));
    }

    /**
     * @param $memberId
     * @param $chatGptModelId
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function createCollect($memberId, $chatGptModelId)
    {
        // 调用保存方法 传入对应dto数据
        return GptModelCollect::query()->firstOrCreate([
            'member_id' => $memberId,
            'chat_gpt_model_id' => $chatGptModelId
        ]);
    }

    public static function deleteById($id)
    {
        ChatGptModel::query()->where('id', $id)->delete();
        ChatGptModelRecord::query()->where('chat_gpt_model_id', $id)->delete();
        GptModelCollect::query()->where('chat_gpt_model_id', $id)->delete();
    }
}
