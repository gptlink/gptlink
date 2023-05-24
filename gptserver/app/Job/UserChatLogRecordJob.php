<?php

namespace App\Job;

use App\Http\Dto\ChatDto;
use App\Http\Dto\ChatLogDto;
use App\Model\ChatLog;
use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;

/**
 *
 */
class UserChatLogRecordJob extends Job
{
    protected $firstId;

    protected $userId;

    protected $resultId;

    /**
     * @var \App\Http\Dto\ChatDto
     */
    protected $dto;

    protected $answerMessage;

    public function __construct($answerMessage, $resultId, ChatDto $dto, $userId, $firstId)
    {
        $this->userId = $userId;
        $this->resultId = $resultId;
        $this->dto = $dto;
        $this->answerMessage = $answerMessage;
        $this->firstId = $firstId;
    }

    public function handle()
    {
        // 没开启记录就不记录日志
        if (! config('custom.user_chat_log')) {
            return ;
        }

        if ($this->dto->last_id) {
            $lastMessage = cache()->get($this->dto->last_id);
        }

        if (in_array($this->userId, explode(',', config('openai.user_white_list')))) {
            return $lastMessage['first_id'] ?? $this->resultId;
        }

        ChatLog::createByDto(new ChatLogDto([
            'id' => $this->resultId,
            'user_id' => $this->userId,
            'first_id' => $lastMessage['first_id'] ?? $this->resultId,
            'parent_id' => $this->dto->last_id,
            'ask' => $this->dto->message,
            'system' => $this->dto->system,
            'answer' => $this->answerMessage,
        ]));

        return $lastMessage['first_id'] ?? $this->resultId;
    }
}
