<?php

namespace App\Http\Control\Web;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\Config\GptSecretKeyDto;
use App\Http\Dto\MemberDto;
use App\Http\Request\Web\UserLoginRequest;
use App\Http\Request\Web\UserRegisterRequest;
use App\Http\Request\Web\UserResetRequest;
use App\Model\Config;
use App\Model\Member;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;

class AuthController extends BaseController
{
    /**
     * 用户登录
     *
     * @param UserLoginRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function login(UserLoginRequest $request)
    {
        $member = Member::query()
            ->where('nickname', $request->input('nickname'))
            ->where('account_type', Member::ACCOUNT_USERNAME)
            ->first();

        throw_unless($member, LogicException::class, ErrCode::USER_LOGIN_FAIL);

        throw_unless(
            $member->verifyPassword($request->input('password')),
            LogicException::class,
            ErrCode::USER_LOGIN_FAIL
        );

        return $this->success($member->getLoginInfo());
    }

    /**
     * 用户注册
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function register(UserRegisterRequest $request)
    {
        /* @var GptSecretKeyDto $config */
        $loginConfig = Config::toDto(Config::GPT_SECRET_KEY);

        throw_unless(
            $loginConfig->login_type == GptSecretKeyDto::LOGIN_TYPE_USERNAME,
            LogicException::class,
            ErrCode::REGISTER_TYPE_NOT_SUPPORT
        );

        $member = Member::createByDto(new MemberDto($request->inputs([
            'nickname', 'mobile', 'source', 'share_openid',
        ])));

        return $this->success($member->getLoginInfo());
    }

    /**
     * 重置密码
     *
     * @param UserResetRequest $request
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function reset(UserResetRequest $request)
    {
        $member = Member::query()
            ->where($request->inputs(['nickname', 'mobile']))
            ->first();

        throw_unless($member, LogicException::class, ErrCode::USER_NOT_FOUND);

        $member->changePassword($request->input('password'));

        return $this->success();
    }

}
