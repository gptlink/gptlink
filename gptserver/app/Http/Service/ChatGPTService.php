<?php

namespace App\Http\Service;

use App\Base\OpenAi\ChatCompletionsRequest;
use App\Base\OpenAi\OpenAIClient;
use App\Http\Dto\ChatDto;
use App\Job\MemberConsumptionJob;
use App\Job\UserChatLogRecordJob;
use App\Model\Config;
use Psr\SimpleCache\InvalidArgumentException;

class ChatGPTService
{
    /**
     * 分块返回
     *
     * @param mixed $userId
     * @param ChatDto $dto
     * @throws InvalidArgumentException
     */
    public function chatProcess($userId, ChatDto $dto)
    {
        // 发送请求
        $client = new OpenAIClient();
        /* @var ChatCompletionsRequest $result */
        $result = $client->exec(new ChatCompletionsRequest($dto));

        logger()->info('openai result', [
            'user_id' => $userId,
            'result' => $result->result,
            'request' => $result->data,
        ]);

        // 如果没有正常返回，不进行扣费与记录
        if ($result->result) {
            asyncQueue(new MemberConsumptionJob($userId));
            asyncQueue(new UserChatLogRecordJob($result->result['messages'], $result->result['id'], $dto, $userId, $cacheMessage['first_id'] ?? ''));
        }
    }
}
