<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Http\Dto\PromptDto;
use App\Model\PromptModel;

class ChatGptModelFactory
{
    public static function createByData(array $payload = [])
    {
        return PromptModel::createByDto(new PromptDto(array_merge([
            'icon' => '#33#333',
            'name' => 'name-test',
            'prompt' => 'prompt-test',
            'system' => 'system-test',
            'status' => PromptModel::STATUS_ON,
            'sort' => 1,
            'platform' => PromptModel::PLATFORM_GPT,
            'desc' => 'test',
            'remark' => 'test',
            'source' => PromptModel::SOURCE_PLATFORM,
            'type' => PromptModel::TYPE_DIALOGUE,
            'user_id' => 0
        ], $payload)));
    }

    public static function deleteById($id)
    {
        PromptModel::query()->where('id', $id)->delete();
    }
}
