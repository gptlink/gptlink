<?php

namespace App\Http\Control\Admin;

use App\Http\Dto\Config\GptSecretKeyDto;
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
     * @param DevelopService $service
     * @return DevelopPackageResource
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws \Throwable
     */
    public function getPackage(DevelopService $service)
    {
        /* @var GptSecretKeyDto $config  */
        $config = \App\Model\Config::toDto(Config::GPT_SECRET_KEY);

        if (empty($config->secret_key) || GptSecretKeyDto::OPENAI == $config->key_type) {
            $response = [
                'name' => null,
                'num' => null,
                'used' => null,
                'expired_at' => null,
            ];
        } else {
            $response = $service->getPackage();
        }

        return new DevelopPackageResource($response);
    }
}
