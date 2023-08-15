<?php

namespace App\Http\Control\Admin;

use App\Http\Dto\Config\AiChatConfigDto;
use App\Http\Dto\Config\SmsConfigDto;
use App\Http\Resource\Admin\DevelopPackageResource;
use App\Http\Service\DevelopService;
use App\Model\Config;
use Cblink\HyperfExt\BaseController;
use GuzzleHttp\Exception\GuzzleException;
use Psr\SimpleCache\InvalidArgumentException;

class DevelopController extends BaseController
{
    /**
     * 获取开发者套餐信息
     *
     * @param DevelopService $service
     * @return DevelopPackageResource|\Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws \Throwable
     */
    public function getPackage(DevelopService $service)
    {
        $data = [];

        $default = ['name' => null, 'num' => 0, 'used' => 0, 'expired_at' => null];

        /* @var AiChatConfigDto $aiChat  */
        $aiChat = Config::toDto(Config::AI_CHAT);
        if (AiChatConfigDto::GPTLINK == $aiChat->channel) {
            $response = $service->getPackage([]);
            $data['chat'] = $response ?: $default;
        }

        /* @var SmsConfigDto $sms  */
        $sms = Config::toDto(Config::SMS);
        if (AiChatConfigDto::GPTLINK == $sms->channel) {
            $response = $service->getPackage(['type' => 3]);
            $data['sms'] = $response ?: $default;
        }

        return $this->success($data);
    }

    /**
     * 获取个人信息
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getProfile(DevelopService $service)
    {
        $result = $service->getProfile();
        return $this->success($result);
    }

    /**
     * 获取开发者消费记录
     * @param DevelopService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getRcord(DevelopService $service)
    {
        $result = $service->getRcord();
        return $this->success($result);
    }
}
