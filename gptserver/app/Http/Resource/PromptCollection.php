<?php

declare(strict_types=1);

namespace App\Http\Resource;

use App\Model\Prompt;
use Cblink\HyperfExt\BaseCollection;

class PromptCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (Prompt $prompt) {
            return [
                'id' => $prompt->id,
                'icon' => $prompt->icon,
                'user_id' => $prompt->user_id,
                'name' => $prompt->name,
                'prompt' => $prompt->prompt,
                'status' => $prompt->status,
                'sort' => $prompt->sort,
                'source' => $prompt->source,
                'uses' => ! empty($prompt->uses) ? $prompt->uses : 0,
                'desc' => $prompt->desc,
                'type' => $prompt->type,
            ];
        })->toArray();
    }
}
