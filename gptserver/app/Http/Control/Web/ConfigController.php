<?php

namespace App\Http\Control\Web;

use App\Http\Dto\Config\ShareConfigDto;
use App\Http\Dto\Config\WebsiteConfigDto;
use App\Http\Dto\Config\PaymentDto;
use App\Http\Dto\Config\ProtocolDto;
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
        /* @var WebsiteConfigDto $config */
        $config = Config::toDto(Config::GPT_SECRET_KEY);

        $result = array_filter(Arr::only($config->toArray(), [
            'name', 'icp', 'web_logo', 'admin_logo',
            'user_logo', 'login_type',
        ]));

        // 默认微信登陆
		return $this->success([
            'name' => $result['name'] ?? '',
            'icp' => $result['icp'] ?? '',
            'web_logo' => $result['web_logo'] ?? '',
            'admin_logo' => $result['admin_logo'] ?? '',
            'user_logo' => $result['user_logo'] ?? '',
            'login_type' => $result['login_type'] ?: WebsiteConfigDto::LOGIN_TYPE_WECHAT,
        ]);
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

    /**
     * 获取支付配置
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function getProtocol()
    {
        /* @var ProtocolDto $config */
        $config = Config::toDto(Config::PROTOCOL);

        return $this->success($config->toArray());
    }

    public function getShare()
    {
        /* @var ShareConfigDto $config */
        $config = Config::toDto(Config::SHARE);

        return $this->success($config->toArray());
    }
}
