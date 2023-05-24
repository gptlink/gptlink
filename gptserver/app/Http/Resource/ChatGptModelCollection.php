<?php

declare(strict_types=1);

namespace App\Http\Resource;

use App\Base\BaseRemoteCollection;
use App\Model\ChatGptModel;
use Cblink\HyperfExt\BaseCollection;

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
                'status' => $chatGptModel->status,
                'sort' => $chatGptModel->sort,
                'source' => $chatGptModel->source,
                'uses' => ! empty($chatGptModel->uses) ? $chatGptModel->uses : 0,
                'desc' => $chatGptModel->desc,
                'type' => $chatGptModel->type,
            ];
        })->toArray();
    }
}
