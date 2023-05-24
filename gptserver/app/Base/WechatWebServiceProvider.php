<?php

namespace App\Base;

use HyperfSocialiteProviders\WeixinWeb\Provider;

class WechatWebServiceProvider extends Provider
{
    /**
     * @param $state
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAuthUrl($state)
    {
        $url = sprintf('http://vpc.k8s.cblink.net:30212/api/official/app/%s/qrcode', $this->getClientId());

        $options = [
            'query' => [
                'redirect_url' => $this->getRedirectUrl(),
                'response_type' => 'code',
                'scope' => $this->formatScopes($this->scopes, $this->scopeSeparator),
                'state' => $state,
            ],
        ];

        $response = $this->getHttpClient()->get($url, $options);

        $data = $response->getBody()->getContents();

        $this->logger()->info('qrlogin', [
            'url' => $url,
            'options' => $options,
            'data' => $data,
        ]);

        return $data;
    }
}
