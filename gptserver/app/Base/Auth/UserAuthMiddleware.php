<?php

declare(strict_types=1);

namespace App\Base\Auth;

use Qbhy\HyperfAuth\AuthMiddleware;

class UserAuthMiddleware extends AuthMiddleware
{
    protected $guards = ['user'];
}
