<?php

namespace App\Http\Resource\Admin;

use App\Model\Package;
use Cblink\HyperfExt\BaseResource;

/**
 * @property $resource
 */
class PackageResource extends BaseResource
{
    public function toArray(): array
    {
        $num = $this->resource->code == Package::CODE_NUM ?
            $this->resource->num :
            $this->resource->expired_day;

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'identity' => $this->resource->identity,
            'num' => $num,
            'price' => $this->resource->price,
            'code' => $this->resource->code,
            'show_name' => $this->resource->show_name,
            'sort' => $this->resource->sort,
            'level' => $this->resource->level,
            'show' => $this->resource->show,
        ];
    }
}
