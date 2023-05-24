<?php

namespace App\Http\Control\Admin;

use App\Http\Request\Admin\LoginRequest;
use App\Http\Service\AdminService;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;

class AuthController extends BaseController
{
    /**
     * @return ResponseInterface
     * @throws \RedisException
     */
    public function login(LoginRequest $request, AdminService $adminService)
    {
        $adminService->isDisabled($request->input('username'));

        [$username, $token] = $adminService->login(
            $request->input('username'),
            $request->input('password'),
            $expire = config('custom.admin.ttl', 7200)
        );

        return $this->success([
            'token_type' => 'Bearer',
            'username' => $username,
            'access_token' => $token,
            'expire' => $expire,
        ]);
    }
}
