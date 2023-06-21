<?php

namespace App\Http\Control\Web;

use App\Http\Dto\Config\AiChatConfigDto;
use App\Http\Dto\Config\LoginConfigDto;
use App\Http\Dto\Config\SalesmanDto;
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
        $config = Config::toDto(Config::WEBSITE);

        $result = array_filter(Arr::only($config->toArray(), [
            'name', 'icp', 'web_logo', 'admin_logo', 'user_logo',
        ]));

        // 默认微信登陆
		return $this->success([
            'name' => $result['name'] ?? '',
            'icp' => $result['icp'] ?? '',
            'web_logo' => $result['web_logo'] ?? '',
            'admin_logo' => $result['admin_logo'] ?? '',
            'user_logo' => $result['user_logo'] ?? '',
        ]);
	}

    /**
     *  获取登录配置
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function getLoginType()
    {
        /* @var LoginConfigDto $config */
        $config = Config::toDto(Config::LOGIN);

        return $this->success([
            'login_type' => $config->login_type,
            'mobile_verify' => $config->mobile_verify,
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

    /**
     * 获取分享配置
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function getShare()
    {
        /* @var ShareConfigDto $config */
        $config = Config::toDto(Config::SHARE);

        return $this->success($config->toArray());
    }

    /**
     * 获取分销配置
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function getSalesman()
    {
        /* @var SalesmanDto $config */
        $config = Config::toDto(Config::SHARE);

        return $this->success([
            'enable' => $config->enable,
            'open' => $config->open,
            'rules' => $config->rules,
        ]);
    }
}
