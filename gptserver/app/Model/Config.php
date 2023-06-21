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
    public const SMS = 4;
    public const WEBSITE = 5;
    public const PROTOCOL = 6;
    public const PAYMENT = 7;
    public const KEYWORD = 8;
    public const SHARE = 9;
    public const SALESMAN = 10;

    public const AI_CHAT = 11;
    public const AI_IMAGE = 12;

    public const LOGIN = 13;

    public const TYPE = [
		self::WECHAT_PLATFORM => '微信公众平台',
		self::WECHAT_PAYMENT => '微信支付',
        self::WECHAT_WEB   => '微信PC应用配置',
        self::SMS => '创蓝短信配置',
        self::WEBSITE => '站点基础配置',
        self::PROTOCOL => '协议配置',
        self::PAYMENT => '支付配置',
        self::KEYWORD => '关键词配置',
        self::SHARE => '分享配置',
        self::SALESMAN => '分销配置',
        self::AI_CHAT => 'ai对话配置',
        self::AI_IMAGE => 'ai绘画配置',
        self::LOGIN => '登陆配置',
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
