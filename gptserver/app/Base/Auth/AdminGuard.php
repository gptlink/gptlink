<?php

declare(strict_types=1);

namespace App\Base\Auth;

use App\Base\Auth\Admin\JwtService;
use App\Base\Auth\Admin\User;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Str;
use Qbhy\HyperfAuth\Authenticatable;
use Qbhy\HyperfAuth\Guard\AbstractAuthGuard;
use Qbhy\HyperfAuth\UserProvider;

class AdminGuard extends AbstractAuthGuard
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var JwtService
     */
    protected $service;

    public function __construct(array $config, string $name, UserProvider $userProvider, RequestInterface $request, JwtService $service)
    {
        parent::__construct($config, $name, $userProvider);
        $this->request = $request;
        $this->service = $service;
    }

    public function login(Authenticatable $user)
    {
        // TODO: Implement login() method.
    }

    public function user(): ?Authenticatable
    {
        if ($accessToken = $this->parseToken()) {
            // 解密内容
            try {
                $jwt = $this->service->decode($accessToken, config('custom.admin.username'), config('custom.admin.secret'));
            } catch (\Exception $exception) {
                return null;
            }

            return new User($jwt);
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function parseToken()
    {
        $header = $this->request->header('authorization', $this->request->header('Authorization'));

        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }

        return null;
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }
}
