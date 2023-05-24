<?php

namespace App\Event;


class UserRegisterTaskEvent
{
    /** @var int  */
    public $userId;
    /** @var string|null  */
    public $shareOpenid;

    public function __construct(int $userId, string|null $shareOpenid=null)
    {
        $this->userId = $userId;
        $this->shareOpenid = $shareOpenid;
    }
}
