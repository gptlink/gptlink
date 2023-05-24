<?php

declare(strict_types=1);

namespace HyperfTest\TestDto;

class RedirectDto extends BaseDto
{
    public function __construct($data = null)
    {
        parent::__construct(array_merge([
            'project' => ['default'],
            'name' => '',
            'category' => '',
            'desc' => '',
            'params' => [],

            'request' => [],
            'request_except' => [],

            'response' => [],
            'response_except' => [],
        ], $data ?? []));
    }
}
