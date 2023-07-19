<?php

namespace App\Http\Control\Web;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\Config\LoginConfigDto;
use App\Http\Dto\MemberDto;
use App\Http\Request\Web\UserLoginRequest;
use App\Http\Request\Web\UserRegisterRequest;
use App\Http\Request\Web\UserResetRequest;
use App\Http\Service\SmsService;
use App\Model\Config;
use App\Model\Member;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;

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
     * @param SmsService $service
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws \RedisException
     * @throws \Throwable
     */
    public function register(UserRegisterRequest $request, SmsService $service)
    {
        /* @var LoginConfigDto $config */
        $loginConfig = Config::toDto(Config::LOGIN);

        throw_unless(
            $loginConfig->login_type == LoginConfigDto::LOGIN_TYPE_USERNAME,
            LogicException::class,
            ErrCode::REGISTER_TYPE_NOT_SUPPORT
        );

        // 手机号查重
        throw_if(
            $request->input('mobile') && Member::query()->where('mobile', $request->input('mobile'))->first(),
            LogicException::class,
            ErrCode::USER_MOBILE_IS_REGISTER
        );

        // 如果开启了手机号验证，需要验证验证码才可使用
        if ($loginConfig->mobile_verify) {
            $service->verifyCode($request->input('mobile'), $request->input('code'));
        }

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
     * @param SmsService $service
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws \RedisException
     * @throws \Throwable
     */
    public function reset(UserResetRequest $request, SmsService $service)
    {
        $member = Member::query()
            ->where($request->inputs(['nickname']))
            ->where('account_type', Member::ACCOUNT_USERNAME)
            ->first();

        $callback = match ($request->input('verify_type')) {
            // 手机号验证
            UserResetRequest::VERIFY_TYPE_MOBILE => function () use ($request, $member, $service) {
                throw_unless(
                    $request->input('verify') == $member->mobile,
                    LogicException::class,
                    ErrCode::USER_VERIFY_FAIL
                );

                /* @var LoginConfigDto $config */
                $loginConfig = Config::toDto(Config::LOGIN);

                // 如果开启了手机号验证，需要验证验证码才可使用
                if ($loginConfig->mobile_verify) {
                    $service->verifyCode($request->input('mobile'), $request->input('code'));
                }
            },
            // 密码验证
            UserResetRequest::VERIFY_TYPE_PASSWORD => function () use ($request, $member) {
                throw_unless(
                    $member->verifyPassword($request->input('verify')),
                    LogicException::class,
                    ErrCode::USER_VERIFY_FAIL
                );
            },
        };

        // 如果是方法，则直接调用
        if ($callback instanceof \Closure) {
            $callback();
        }

        $member->changePassword($request->input('password'));

        return $this->success();
    }
}
