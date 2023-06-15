<?php

namespace App\Http\Control\Web;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\Config\WebsiteConfigDto;
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
     * @param UserRegisterRequest $request
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function register(UserRegisterRequest $request)
    {
        /* @var WebsiteConfigDto $config */
        $loginConfig = Config::toDto(Config::GPT_SECRET_KEY);

        throw_unless(
            $loginConfig->login_type == WebsiteConfigDto::LOGIN_TYPE_USERNAME,
            LogicException::class,
            ErrCode::REGISTER_TYPE_NOT_SUPPORT
        );

        // 手机号查重
        throw_if(
            $request->input('mobile') && Member::query()->where('mobile', $request->input('mobile'))->first(),
            LogicException::class,
            ErrCode::USER_MOBILE_IS_REGISTER
        );

        $member = Member::createByDto(new MemberDto(array_merge($request->inputs([
            'nickname', 'mobile', 'source', 'share_openid',
        ]), [
            'account_type' => Member::ACCOUNT_USERNAME,
        ])));

        $member->changePassword($request->input('password'));

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
            ->where($request->inputs(['nickname']))
            ->where('account_type', Member::ACCOUNT_USERNAME)
            ->first();

        $verify = $request->input('verify_type') == UserResetRequest::VERIFY_TYPE_MOBILE ?
            ($request->input('verify') == $member->mobile) :
            $member->verifyPassword($request->input('verify'));

        throw_unless($verify, LogicException::class, ErrCode::USER_VERIFY_FAIL);

        $member->changePassword($request->input('password'));

        return $this->success();
    }

}
