<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\Prompt;
use Cblink\HyperfExt\BaseCollection;
use Hyperf\Utils\Arr;

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
                'system' => $prompt->system,
                'status' => $prompt->status,
                'sort' => $prompt->sort,
                'type' => $prompt->type,
                'desc' => $prompt->desc,
                'likes' => Arr::get($prompt, 'likes', 0),
                'uses' => Arr::get($prompt, 'uses', 0),
                'source' => $prompt->source,
                'nickname' => Arr::get($prompt->member, 'nickname'),
                'mobile' => Arr::get($prompt->member, 'mobile'),
                'remark' => $prompt->remark,
            ];
        })->toArray();
    }
}
