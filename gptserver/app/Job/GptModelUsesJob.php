<?php

namespace App\Job;

use App\Model\ChatGptModelCount;
use Hyperf\AsyncQueue\Job;

/**
 *
 */
class GptModelUsesJob extends Job
{

    protected $gptModelId;

    public function __construct(string $gptModelId)
    {
        $this->gptModelId = $gptModelId;
    }

    public function handle()
    {
        $gptModelUses = ChatGptModelCount::query()
            ->firstOrCreate(['chat_gpt_model_id' => $this->gptModelId]);

        // 使用量增加
        $gptModelUses->increment('uses');
    }
}
