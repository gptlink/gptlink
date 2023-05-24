<?php

namespace App\Http\Resource\Admin;

use Cblink\HyperfExt\BaseResource;
use Hyperf\Utils\Arr;

/**
 * @property $resource
 */
class ChatGptModelResource extends BaseResource
{
    public function toArray(): array
    {
        $data = [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'icon' => $this->resource->icon,
            'name' => $this->resource->name,
            'prompt' => $this->resource->prompt,
            'system' => $this->resource->system,
            'status' => $this->resource->status,
            'sort' => $this->resource->sort,
            'platform' => $this->resource->platform,
            'desc' => $this->resource->desc,
            'remark' => $this->resource->remark,
            'type' => $this->resource->type,
        ];
        // 违规记录数据存在
        if($this->resource->lastRecord){
            $data['violation_record']['label'] = Arr::get($this->resource->record, 'label');
            $data['violation_record']['trigger'] = Arr::get($this->resource->record, 'trigger');
        }

        return $data;
    }

}
