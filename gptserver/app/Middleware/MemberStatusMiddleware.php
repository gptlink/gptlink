<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\UserDisableException;
use App\Model\Member;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MemberStatusMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (auth('user')->check() && auth('user')->user()->status == Member::STATUS_NORMAL) {
            return $handler->handle($request);
        }

        throw new UserDisableException();
    }
}
