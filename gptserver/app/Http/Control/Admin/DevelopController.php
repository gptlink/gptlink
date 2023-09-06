<?php

namespace App\Http\Control\Admin;

use App\Http\Dto\Config\AiChatConfigDto;
use App\Http\Dto\Config\SmsConfigDto;
use App\Http\Service\GPTLinkChatService;
use App\Model\Config;
use Cblink\HyperfExt\BaseController;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class DevelopController extends BaseController
{
    /**
     * 获取开发者套餐信息
     *
     * @param GPTLinkChatService $service
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws \Throwable
     */
    public function getPackage(GPTLinkChatService $service)
    {
        $data = [];

        $default = ['name' => null, 'num' => 0, 'used' => 0, 'expired_at' => null];

        /* @var AiChatConfigDto $aiChat  */
        $aiChat = Config::toDto(Config::AI_CHAT);
        if (AiChatConfigDto::GPTLINK == $aiChat->channel) {
            $response = $service->getPackage();
            $data['chat'] = $response ?: $default;
        }

        /* @var SmsConfigDto $sms  */
        $sms = Config::toDto(Config::SMS);
        if (AiChatConfigDto::GPTLINK == $sms->channel) {
            $response = make(GPTLinkChatService::class, [$sms->gptlink['api_key']])->getPackage(['type' => 3]);
            $data['sms'] = $response ?: $default;
        }

        return $this->success($data);
    }

    /**
     * 获取个人信息
     * @param GPTLinkChatService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getProfile(GPTLinkChatService $service)
    {
        $result = $service->getProfile();
        return $this->success($result);
    }

    /**
     * 获取开发者消费记录
     * @param GPTLinkChatService $service
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getRcord(GPTLinkChatService $service)
    {
        $result = $service->getRecord();
        return $this->success($result);
    }
}
