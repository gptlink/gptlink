<?php

namespace App\Exception;

class FailReturnException extends \Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}
