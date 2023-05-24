<?php

namespace App\Exception;

class UserDisableException extends \Exception
{
    public function __construct()
    {
        parent::__construct('', ErrCode::MEMBER_ACCOUNT_DISABLED);
    }
}
