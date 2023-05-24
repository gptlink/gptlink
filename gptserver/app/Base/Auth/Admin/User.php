<?php

namespace App\Base\Auth\Admin;

use Hyperf\Utils\Arr;
use Qbhy\HyperfAuth\Authenticatable;

class User implements Authenticatable
{
    /**
     * @var
     */
    public $info;

    public function __construct($user)
    {
        $this->info = $user;
    }

    /**
     * 获取UserId
     *
     * @return mixed
     */
    public function getId()
    {
        return Arr::get($this->info, $this->getAuthIdentifierName());
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName(): string
    {
        return 'user_id';
    }

    public static function retrieveById($key): ?Authenticatable
    {
        return make(static::class);
    }
}
