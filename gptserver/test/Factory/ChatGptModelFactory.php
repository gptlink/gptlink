<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Http\Dto\ChatGptModelDto;
use App\Model\ChatGptModel;

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
            'platform' => ChatGptModel::PLATFORM_GPT,
            'desc' => 'test',
            'remark' => 'test',
            'source' => ChatGptModel::SOURCE_PLATFORM,
            'type' => ChatGptModel::TYPE_DIALOGUE,
            'user_id' => 0
        ], $payload)));
    }

    public static function deleteById($id)
    {
        ChatGptModel::query()->where('id', $id)->delete();
    }
}
