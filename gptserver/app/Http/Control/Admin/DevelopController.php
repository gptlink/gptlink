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

        /* @var AiChatConfigDto $aiChat */
        $aiChat = Config::toDto(Config::AI_CHAT);

        if ($aiChat->channel == AiChatConfigDto::GPTLINK) {
            $response = $service->getPackage();

            if ($response['err_code'] == 0) {
                $data['chat'] = $response['data'] ?: $default;
            }
        }

        /* @var SmsConfigDto $sms */
        $sms = Config::toDto(Config::SMS);

        if ($sms->channel == AiChatConfigDto::GPTLINK) {
            $response = $service->getPackage(['type' => 3]);

            if ($response['err_code'] == 0) {
                $data['sms'] = $response['data'] ?: $default;
            }
        }

        return $this->success($data);
    }
}
