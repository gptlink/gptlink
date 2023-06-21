<?php

namespace App\Middleware;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Model\Member;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SalesmanMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (auth('user')->check() && auth('user')->user()->identity == Member::IDENTITY_SALESMAN) {
            return $handler->handle($request);
        }

        throw new LogicException(ErrCode::FORBIDDEN);
    }
}
