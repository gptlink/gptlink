<?php

declare(strict_types=1);

namespace App\Base\Auth;

use Qbhy\HyperfAuth\AuthMiddleware;

class AdminAuthMiddleware extends AuthMiddleware
{
    protected $guards = ['admin'];
}
