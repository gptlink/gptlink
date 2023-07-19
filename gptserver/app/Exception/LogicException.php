<?php

namespace App\Exception;

use LogicException as BaseLogicException;

class LogicException extends BaseLogicException
{
    public function __construct($code = -1)
    {
        parent::__construct('', $code);
    }
}
