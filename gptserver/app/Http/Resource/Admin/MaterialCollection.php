<?php

declare(strict_types=1);

namespace App\Http\Resource\Admin;

use App\Model\Material;
use Cblink\HyperfExt\BaseCollection;

class MaterialCollection extends BaseCollection
{
    public function toArray(): array
    {
        return $this->resource->map(function (Material $material) {
            return [
                'id' => $material->id,
                'type' => $material->type,
                'title' => $material->title,
                'file_url' => $material->file_url,
                'size' => $material->size,
                'format' => $material->format,
                'width' => $material->width,
                'height' => $material->height,
            ];
        })->toArray();
    }
}
