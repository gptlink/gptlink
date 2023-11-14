<?php

namespace App\Base\Sms;

use Overtrue\EasySms\Contracts\MessageInterface;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;
use Overtrue\EasySms\Exceptions\GatewayErrorException;
use Overtrue\EasySms\Gateways\Gateway;
use Overtrue\EasySms\Support\Config;
use Overtrue\EasySms\Traits\HasHttpRequest;

class GptlinkGateway extends Gateway
{
    use HasHttpRequest;

    const ENDPOINT_URL = 'https://api.aiyaaa.net/v1/sms/send';

    /**
     * @param PhoneNumberInterface $to
     * @param MessageInterface $message
     * @param Config $config
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws GatewayErrorException
     */
    public function send(PhoneNumberInterface $to, MessageInterface $message, Config $config)
    {
        $data = array_merge([
            'mobile' => $to->getNumber(),
        ], $message->getData($this));

        $result = $this->post(self::ENDPOINT_URL, $data, [
            'Authorization' => sprintf('Bearer %s', $config->get('api_key')),
        ]);

        if ($result['err_code'] != 0) {
            throw new GatewayErrorException($result['err_msg'], $result['err_code'], $result);
        }

        return $result;
    }
}
