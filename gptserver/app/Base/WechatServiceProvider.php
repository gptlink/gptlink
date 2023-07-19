<?php

namespace App\Base;

use HyperfSocialiteProviders\Weixin\Provider;

class WechatServiceProvider extends Provider
{
    public function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->getJumpUrl(), $state);
    }

    /**
     * {@inheritdoc}.
     */
    protected function getCodeFields($state = null)
    {
        return [
            'appid' => $this->getClientId(),
            'redirect_url' => $this->getRedirectUrl(),
            'response_type' => 'code',
            'scope' => $this->formatScopes($this->scopes, $this->scopeSeparator),
            'state' => $state,
        ];
    }

    /**
     * 跳板地址
     *
     * @return string
     */
    protected function getJumpUrl()
    {
        return sprintf('https://wechat.service.cblink.net/api/official/app/%s/handle', $this->getClientId());
    }
}
