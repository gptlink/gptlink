<?php

namespace App\Exception;

class ChatgptException extends \InvalidArgumentException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message, ErrCode::BAD_REQUEST);
    }
}
