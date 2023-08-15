<?php

namespace App\Model\Repository;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\Config\ConfigDtoInterface;
use App\Model\Config;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Psr\SimpleCache\InvalidArgumentException;

trait ConfigTrait
{
	// 动态的dto类型
	public static $transfer = [
		Config::WECHAT_PLATFORM => \App\Http\Dto\Config\WechatPlatformDto::class, // 公众平台
		Config::WECHAT_PAYMENT => \App\Http\Dto\Config\WechatPaymentDto::class, // 微信支付
        Config::WECHAT_WEB => \App\Http\Dto\Config\WechatWebDto::class,  // 微信 web 端
        Config::SMS => \App\Http\Dto\Config\SmsConfigDto::class,   // 创蓝
        Config::WEBSITE => \App\Http\Dto\Config\WebsiteConfigDto::class,   // 站点配置
        Config::PROTOCOL => \App\Http\Dto\Config\ProtocolDto::class, // 协议配置
        Config::PAYMENT => \App\Http\Dto\Config\PaymentDto::class,  // 支付配置
        Config::KEYWORD => \App\Http\Dto\Config\KeywordDto::class, // 关键词配置
        Config::SHARE => \App\Http\Dto\Config\ShareConfigDto::class, // 分享配置
        Config::SALESMAN => \App\Http\Dto\Config\SalesmanDto::class, // 分销员
        Config::AI_CHAT => \App\Http\Dto\Config\AiChatConfigDto::class, // AI对话
        Config::AI_IMAGE => \App\Http\Dto\Config\AiImageConfigDto::class, // AI绘画
        Config::LOGIN => \App\Http\Dto\Config\LoginConfigDto::class, // 登陆配置
	];

	// 根据类型 直接new相应的dto并传入数据
	public static function getTypeByDto($type, $params)
	{
		return new static::$transfer[$type]($params);
	}

    /**
     * 更新或创建
     * @param ConfigDtoInterface $dto
     * @return Builder|Model
     * @throws InvalidArgumentException
     */
	public static function updateOrCreateByDto(ConfigDtoInterface $dto)
	{
        cache()->delete($dto::class);

        return Config::query()->updateOrCreate(
			$dto->getUniqueFillable(),
			$dto->getConfigFillable()
		);
	}

	/**
	 * 获取配置
	 * @param $type
	 * @return mixed
	 * @throws \Throwable
	 */
	public static function toDto($type)
	{
		throw_if(!in_array($type, array_keys(Config::TYPE)), LogicException::class, ErrCode::TYPE_IS_INVALID);

        if (! $config = cache()->get($class = Config::$transfer[$type])) {
            $config = Config::query()->where('type', $type)->first();
            $config = $config ? $config->config : [];
            cache()->set($class, $config);
        }

		return self::getTypeByDto($type, $config);
	}

    /**
     * 获取微信相关配置
     *
     * @param string $platform
     * @return mixed
     * @throws \Throwable
     */
    public static function getWechatConfig(string $platform)
    {
        /** @var ConfigDtoInterface  $configDto */
        if($platform == 'weixin'){
            $configDto = self::toDto(Config::WECHAT_PLATFORM);
        }else{
            $configDto = self::toDto(Config::WECHAT_WEB);
        }
        $config = $configDto->getDefaultConfig();
        unset($config['type']);
        return $config;
    }
}
