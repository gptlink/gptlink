<?php

namespace App\Job;

use App\Model\PromptCount;
use Hyperf\AsyncQueue\Job;

class GptModelUsesJob extends Job
{
    protected $promptId;

    public function __construct(string $promptId)
    {
        $this->promptId = $promptId;
    }

    public function handle()
    {
        $gptModelUses = PromptCount::query()
            ->firstOrCreate(['prompt_id' => $this->promptId]);

        // 使用量增加
        $gptModelUses->increment('uses');
    }
}
