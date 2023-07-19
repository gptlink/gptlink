<?php

namespace App\Http\Service;

use App\Base\Auth\Admin\JwtService;
use App\Exception\ErrCode;
use App\Exception\LogicException;

class AdminService
{
    /**
     * @var JwtService
     */
    protected $jwt;

    protected string $prefix = 'admin_login_disable_';

    public function __construct(JwtService $jwtService)
    {
        $this->jwt = $jwtService;
    }

    /**
     * 超管登陆
     *
     * @param $username
     * @param $password
     * @param int $expire
     * @return array
     * @throws \RedisException
     */
    public function login($username, $password, int $expire = 7200)
    {
        if (
            $username != config('custom.admin.username')
            || $password != config('custom.admin.password')
        ) {
            $tryAttempts = redis()->incr(sprintf('admin_login_%s', $username));

            if ($tryAttempts >= 10) {
                redis()->set($this->prefix . $username, 1, 600);
            }

            throw new LogicException(ErrCode::ADMIN_LOGIN_FAIL);
        }

        return [
            config('custom.admin.username'),
            $this->jwt->encode(
                ['user_id' => config('custom.admin.username')],
                config('custom.admin.username'),
                config('custom.admin.secret'),
                $expire
            ),
        ];
    }

    /**
     * @param $username
     * @throws \RedisException
     * @throws \Throwable
     */
    public function isDisabled($username)
    {
        throw_if(
            redis()->get($this->prefix . $username),
            LogicException::class,
            ErrCode::ADMIN_LOGIN_ATTEMPTS
        );
    }
}
