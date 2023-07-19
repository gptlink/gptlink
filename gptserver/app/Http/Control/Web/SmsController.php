<?php

namespace App\Http\Control\Web;

use App\Http\Dto\MemberRegisterDto;
use App\Http\Request\Web\SendSmsRequest;
use App\Http\Request\Web\SmsMobileRequest;
use App\Http\Service\MemberOauthService;
use App\Http\Service\SmsService;
use App\Model\MemberOauth;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;

class SmsController extends BaseController
{
    /**
     * 发送短信
     *
     * @param SendSmsRequest $request
     * @param SmsService $smsService
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws \Throwable
     */
    public function sendSmsCode(SendSmsRequest $request, SmsService $smsService)
    {
        // 发送短信验证码
        $smsService->sendLoginSms($request->input('mobile'));

        return $this->success();
    }

    /**
     * 完成短信登陆
     *
     * @param SmsMobileRequest $request
     * @param SmsService $smsService
     * @param MemberOauthService $memberOauthService
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws \Throwable
     */
    public function login(SmsMobileRequest $request, SmsService $smsService, MemberOauthService $memberOauthService)
    {
        // 验证码，验证完成后就删除
        $smsService->verifyCode($request->input('mobile'), $request->input('code'));

        $memberOauth = MemberOauth::query()->findOrFail(base64_decode($request->input('oauth_id')));

        logger()->info('user register', array_merge($request->inputs([
            'mobile', 'share_openid', 'source', 'oauth_id',
        ]), ['time' => microtime()]));

        $member = $memberOauthService->createMember(new MemberRegisterDto($request->inputs([
            'mobile', 'share_openid', 'source',
        ])), $memberOauth);

        return $this->success($member->getLoginInfo());
    }
}
