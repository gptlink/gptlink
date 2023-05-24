<?php

namespace App\Http\Resource;

use Cblink\HyperfExt\BaseResource;
use Hyperf\Utils\Arr;

class ChatResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => Arr::get($this->resource, 'id'),
            'model' => Arr::get($this->resource, 'model'),
            'messages' => Arr::get($this->resource, 'choices.0.message'),
            'created' => Arr::get($this->resource, 'created'),
        ];
    }
}
