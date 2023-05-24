<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\ChatGptModel;
use Cblink\HyperfExt\BaseCollection;
use Hyperf\Utils\Arr;

class ChatGptModelCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (ChatGptModel $chatGptModel) {
            return [
                'id' => $chatGptModel->id,
                'icon' => $chatGptModel->icon,
                'user_id' => $chatGptModel->user_id,
                'name' => $chatGptModel->name,
                'prompt' => $chatGptModel->prompt,
                'system' => $chatGptModel->system,
                'status' => $chatGptModel->status,
                'sort' => $chatGptModel->sort,
                'type' => $chatGptModel->type,
                'desc' => $chatGptModel->desc,
                'likes' => Arr::get($chatGptModel, 'likes', 0),
                'uses' => Arr::get($chatGptModel, 'uses', 0),
                'source' => $chatGptModel->source,
                'nickname' => Arr::get($chatGptModel->member, 'nickname'),
                'mobile' => Arr::get($chatGptModel->member, 'mobile'),
                'remark' => $chatGptModel->remark,
            ];
        })->toArray();
    }
}
