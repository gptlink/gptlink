<?php

namespace App\Base\OpenAi;

interface RequestInterface
{
    /**
     * @param OpenAIClient $client
     * @return mixed
     */
    public function send(OpenAIClient $client): mixed;
}
