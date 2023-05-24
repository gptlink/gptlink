<?php

declare(strict_types=1);

namespace App\Http\Resource;

use App\Model\Package;
use Cblink\HyperfExt\BaseCollection;
use Hyperf\Utils\Collection;

/**
 * @property Collection $resource
 */
class PackageCollection extends BaseCollection
{
    protected $business_id;

    public function __construct($resource, $business_id)
    {
        parent::__construct($resource);
        $this->business_id = $business_id;
    }

    public function toArray(): array
    {
        $filter = (bool) $this->resource->where('business_id', $this->business_id)->count();

        return $this->resource->when($filter, function ($collection) {
            return $collection->where('business_id', $this->business_id);
        })->map(function (Package $model) {
            return [
                'id' => $model->id,
                'identity' => $model->identity,
                'name' => $model->name,
                'type' => $model->type,
                'expired_day' => $model->expired_day,
                'num' => $model->num,
                'price' => $model->price,
            ];
        })->filter()->toArray();
    }
}
