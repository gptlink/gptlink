<?php

namespace App\Model\Repository;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\Config\ConfigDtoInterface;
use App\Http\Dto\Config\GptSecretKeyDto;
use App\Http\Dto\Config\KeywordDto;
use App\Http\Dto\Config\PaymentDto;
use App\Http\Dto\Config\ProtocolDto;
use App\Http\Dto\Config\SmsChuangLanDto;
use App\Http\Dto\Config\WechatPaymentDto;
use App\Http\Dto\Config\WechatPlatformDto;
use App\Http\Dto\Config\WechatWebDto;
use App\Http\Service\DevelopService;
use App\Model\Config;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Psr\SimpleCache\InvalidArgumentException;

trait ConfigTrait
{

	// 动态的dto类型
	public static $transfer = [
		Config::WECHAT_PLATFORM => WechatPlatformDto::class, // 公众平台
		Config::WECHAT_PAYMENT => WechatPaymentDto::class, // 微信支付
        Config::WECHAT_WEB => WechatWebDto::class,  // 微信 web 端
        Config::SMS_CHUANG_LAN => SmsChuangLanDto::class,   // 创蓝
        Config::GPT_SECRET_KEY => GptSecretKeyDto::class,   // 站点配置
        Config::PROTOCOL => ProtocolDto::class, // 协议配置
        Config::PAYMENT => PaymentDto::class,  // 支付配置
        Config::KEYWORD => KeywordDto::class, // 关键词配置
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
        if ($dto instanceof GptSecretKeyDto) {
            DevelopService::clearApiKeyCache();
        }

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

		$config = Config::query()->where([
			'type' => $type,
		])->first();

		$data = $config ? $config->config : [];

		return self::getTypeByDto($type, $data);
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
