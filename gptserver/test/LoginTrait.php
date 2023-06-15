<?php

namespace HyperfTest;

use App\Base\Auth\Admin\JwtService;
use App\Model\Member;
use Hyperf\Utils\Str;
use HyperfTest\Factory\MemberFactory;

trait LoginTrait
{
    /**
     * @return Member
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function userLogin()
    {
        $token = auth()->login($member = MemberFactory::createByData());

        $this->headers['Authorization'] = sprintf('Bearer %s', $token);

        return $member;
    }

    public function adminLogin(array $info = [])
    {
        $userInfo = array_merge(['user_id' => $username = config('custom.admin.username')], $info);

        $accessToken = make(JwtService::class)->encode($userInfo, $username, config('custom.admin.secret'));

        $this->headers['Authorization'] = sprintf('Bearer %s', $accessToken);

        return $userInfo;
    }

}
