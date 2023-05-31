<?php

namespace App\Http\Control\Web;

use App\Http\Dto\Config\GptSecretKeyDto;
use App\Http\Dto\Config\PaymentDto;
use App\Model\Config;
use Cblink\HyperfExt\BaseController;
use Hyperf\Utils\Arr;
use Psr\Http\Message\ResponseInterface;

class ConfigController extends BaseController
{
    /**
     * 配置项获取
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
	public function getBasicInfo()
	{
        /* @var GptSecretKeyDto $config */
        $config = Config::toDto(Config::GPT_SECRET_KEY);

        $result = array_filter(Arr::only($config->toArray(), [
            'name', 'icp', 'web_logo', 'admin_logo',
            'user_logo', 'login_type',
        ]));

        // 默认微信登陆
		return $this->success(array_merge([
            'login_type' => GptSecretKeyDto::LOGIN_TYPE_WECHAT,
        ], $result));
	}

    /**
     * 获取支付配置
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function getPayment()
    {
        /* @var PaymentDto $config */
        $config = Config::toDto(Config::PAYMENT);

        return $this->success([
            'channel' => $config->channel,
            'offline' => $config->offline,
        ]);
    }
}
