<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\ConfigTrait;
use Hyperf\DbConnection\Model\Model;

class Config extends Model
{
    use ConfigTrait;

	public const WECHAT_PLATFORM = 1;
	public const WECHAT_PAYMENT = 2;
    public const WECHAT_WEB = 3;
    public const SMS_CHUANG_LAN=4;
    public const GPT_SECRET_KEY=5;
    public const PROTOCOL = 6;
    public const PAYMENT = 7;

    public const TYPE = [
		self::WECHAT_PLATFORM => '微信公众平台',
		self::WECHAT_PAYMENT => '微信支付',
        self::WECHAT_WEB   => '微信PC应用配置',
        self::SMS_CHUANG_LAN => '创蓝短信配置',
        self::GPT_SECRET_KEY => 'api密钥',
        self::PROTOCOL => '协议配置',
        self::PAYMENT => '支付配置',
	];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'config'];

	protected $casts = ['config' => 'array'];
}
