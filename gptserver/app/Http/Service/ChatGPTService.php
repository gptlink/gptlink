<?php

namespace App\Http\Service;

use App\Base\OpenAi\ChatCompletionsRequest;
use App\Base\OpenAi\OpenaiChatCompletionsRequest;
use App\Base\OpenAi\OpenAIClient;
use App\Http\Dto\ChatDto;
use App\Http\Dto\Config\GptSecretKeyDto;
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
        [$result, $request] = $this->exec($dto, $userId);

        // 如果没有正常返回，不进行扣费与记录
        if ($result->result) {

            if (! $request instanceof ChatCompletionsRequest) {
                $dto->cached($result->result['id'], $result->result['messages']);
            }

            asyncQueue(new MemberConsumptionJob($userId));
            asyncQueue(new UserChatLogRecordJob(
                $result->result['messages'],
                $result->result['id'],
                $dto,
                $userId,
                $cacheMessage['first_id'] ?? ''
            ));
        }
    }

    /**
     * 发送请求
     *
     * @param ChatDto $dto
     * @param $userId
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     */
    public function exec(ChatDto $dto, $userId)
    {
        $keyType = Config::toDto(Config::GPT_SECRET_KEY)->key_type;

        // 发送请求
        $client = new OpenAIClient($keyType);

        $request = match ($keyType){
            GptSecretKeyDto::OPENAI => new OpenaiChatCompletionsRequest($dto),
            default => new ChatCompletionsRequest($dto),
        };

        /* @var ChatCompletionsRequest $result */
        $result = $client->exec($request);

        logger()->info('openai result', [
            'user_id' => $userId,
            'result' => $result->result,
            'request' => $result->data,
            'debug' => $result->debug,
            'class' => $request::class,
            'key' => DevelopService::getApikey(),
            'key_type' => $keyType,
        ]);

        return [$result, $request];
    }
}
