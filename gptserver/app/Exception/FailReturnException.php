<?php

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;
use Throwable;

class FailReturnException extends \Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}
