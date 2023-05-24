<?php

namespace App\Http\Resource\Admin;

use App\Model\Material;
use App\Model\Member;
use Cblink\HyperfExt\BaseResource;

/**
 * @property Material $resource
 */
class MaterialResource extends BaseResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'title' => $this->resource->title,
            'file_url' => $this->resource->file_url,
            'size' => $this->resource->size,
            'format' => $this->resource->format,
            'width' => $this->resource->width,
            'height' => $this->resource->height,
        ];
    }
}
