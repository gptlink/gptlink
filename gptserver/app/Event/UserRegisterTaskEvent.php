<?php

namespace App\Event;

class UserRegisterTaskEvent
{
    /** @var int */
    public $userId;

    /** @var null|string */
    public $shareOpenid;

    public function __construct(int $userId, string|null $shareOpenid = null)
    {
        $this->userId = $userId;
        $this->shareOpenid = $shareOpenid;
    }
}
