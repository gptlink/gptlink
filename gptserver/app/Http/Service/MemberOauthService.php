<?php

namespace App\Http\Service;

use App\Event\UserRegisterTaskEvent;
use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\Config\WebsiteConfigDto;
use App\Http\Dto\Config\SmsChuangLanDto;
use App\Http\Dto\MemberDto;
use App\Http\Dto\MemberRegisterDto;
use App\Http\Dto\OauthDto;
use App\Job\UserRegisterRecordJob;
use App\Model\Config;
use App\Model\Member;
use App\Model\MemberOauth;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;

class MemberOauthService
{
    /**
     * 第三方登陆处理
     *
     * @param OauthDto $dto
     * @return array
     * @throws \Throwable
     */
    public function oauthLogin(OauthDto $dto)
    {
        // 登陆或注册
        $memberOrOath = $this->registerOrLogin($dto);
        // 返回数据 注册返回第三方信息 登陆返回用户登陆信息
        return $memberOrOath instanceof MemberOauth ?
            ['oauth_id' => base64_encode($memberOrOath->id)] :
            $memberOrOath->getLoginInfo();
    }

    /**
     * 注册或登陆
     *
     * @param OauthDto $dto
     * @return null|Builder|Builder[]|Collection|Model|Member|Member[]|object
     * @throws \Throwable
     */
    public function registerOrLogin(OauthDto $dto)
    {
        // 1. 判断第三方来源根据来源创建数据或者查询返回
        $oauth = MemberOauth::findOrcreateByDto($dto);

        /* @var WebsiteConfigDto $config */
        $loginConfig = Config::toDto(Config::GPT_SECRET_KEY);

        if ($oauth->member_id == 0 && $dto->unionid && $thirdOauth = MemberOauth::query()->where('member_id', '>', 0)->where('unionid', $dto->unionid)->first()) {
            $oauth->member_id = $thirdOauth->member_id;
            $oauth->save();
        }

        // 判断是否存在会员信息
        if ($oauth->member_id && $member = Member::query()->findOrFail($oauth->member_id)) {
            return $member;
        }

        // 如果手机号登录未开启，则不进行下一步操作
        return $loginConfig->login_type == WebsiteConfigDto::LOGIN_TYPE_WECHAT_AND_MOBILE ?
            $oauth :
            $this->createMember(new MemberRegisterDto([
                'share_openid' => $dto->share_openid,
                'source' => $dto->source,
            ]), $oauth);
    }

    /**
     * 创建用户返回登陆信息
     *
     * @param MemberRegisterDto $dto
     * @param MemberOauth $oauth
     * @return Member|array|Builder|Model
     * @throws \Throwable
     */
    public function createMember(MemberRegisterDto $dto, MemberOauth $oauth)
    {
        if ($dto->mobile) {
            // 创建用户
            $member = Member::query()
                ->where('mobile', $dto->mobile)
                ->where('account_type', Member::ACCOUNT_MOBILE)
                ->first();

            if ($member) {
                // 查询是否绑定其他的认证信息
                $exists = MemberOauth::query()->where([
                    'member_id' => $member->id,
                    'platform' => $oauth->platform,
                    'appid' => $oauth->appid,
                ])->first();

                throw_if($exists, LogicException::class, ErrCode::USER_MOBILE_IS_BIND);

                // 修改用户信息
                $oauth->updateMemberId($member->id);

                return $member->getLoginInfo();
            }
        }

        $member = Member::createByDto(new MemberDto(array_filter([
            'nickname' => $oauth->nickname,
            'avatar' => $oauth->avatar,
            'mobile' => $dto->mobile,
            'source' => $dto->source,
            'share_openid' => $dto->share_openid
        ])));

        // 修改用户信息
        $oauth->updateMemberId($member->id);

        // 返回登陆信息
        return $member;
    }
}
