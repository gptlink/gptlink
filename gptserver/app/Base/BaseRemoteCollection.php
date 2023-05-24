<?php

namespace App\Base;

use Cblink\HyperfExt\Traits\ApiResponse;
use Hyperf\Resource\Json\ResourceCollection;
use Psr\Http\Message\ResponseInterface;

class BaseRemoteCollection extends ResourceCollection
{
    use ApiResponse;

    /**
     * @var array
     */
    protected $meta;

    public function __construct($resource, array $meta = [])
    {
        parent::__construct($resource);
        $this->meta = $meta;
    }

    public function toResponse(): ResponseInterface
    {
        return $this->success($this->toArray(), $this->meta);
    }
}
