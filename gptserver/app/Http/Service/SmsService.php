<?php

namespace App\Http\Service;

use App\Base\Sms\GptlinkGateway;
use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\Config\SmsConfigDto;
use App\Model\Config;
use Hyperf\Utils\Arr;
use Overtrue\EasySms\EasySms;
use Psr\SimpleCache\InvalidArgumentException;

class SmsService
{
    /**
     * 验证码有效期
     *
     * @var int
     */
    public $expireAt = 300;

    /**
     * 发送有效期
     *
     * @var int
     */
    public $sendExpireAt = 60;

    /**
     * @var SmsConfigDto
     */
    protected $config;

    public function __construct()
    {
        $this->config = Config::toDto(Config::SMS);
    }

    /**
     * 发送逻辑
     *
     * @param $mobile
     * @return int
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     */
    public function sendLoginSms($mobile)
    {
        // 验证缓存
        $data = cache()->get($this->getLoginKey($mobile));

        // 如果60秒内重复发送验证码，提示异常
        throw_if(
            (time() - $this->sendExpireAt) < Arr::get($data, 'lock_at'),
            LogicException::class,
            ErrCode::LOGIN_SMS_CODE_VALID
        );

        return $this->sendCode($mobile);
    }

    /**
     * 验证验证码
     *
     * @param $mobile
     * @param $code
     * @param int $attempts
     * @return true
     * @throws InvalidArgumentException
     * @throws \RedisException
     */
    public function verifyCode($mobile, $code, int $attempts = 6)
    {
        throw_if(is_null($code), LogicException::class, ErrCode::LOGIN_SMS_CODE_ERROR);

        // 获取缓存与用户提交做对比
        $data = cache()->get($this->getLoginKey($mobile));

        // 如果验证成功了
        if (Arr::get($data, 'code') != $code) {
            // 错误了记录一下的信息
            $tryAttempts = redis()->incr($attemptsKey = config('cache.default.prefix') . $this->getLoginAttemptsKey($mobile));

            // 如果尝试的次数超过了10次，则删除这个验证码
            $tryAttempts >= $attempts ?
                $this->deleteLoginCache($mobile) :
                redis()->expire($attemptsKey, $this->expireAt);

            throw new LogicException(ErrCode::LOGIN_SMS_CODE_ERROR);
        }

        $this->deleteLoginCache($mobile);
    }

    /**
     * @param $code
     * @return array
     */
    public function getData($code)
    {
        return match ($this->config->channel) {
            'aliyun' => [
                'template' => $this->config->getItem('aliyun.template'),
                'data' => ['code' => $code],
            ],
            'gptlink' => [
                'template' => 'register',
                'data' => ['rand_code' => $code],
            ],
            'chuanglan' => [
                'content' => sprintf('【%s】您的验证码是%s。请尽快使用', $this->config->getItem('chuanglan.sign'), $code),
            ],
        };
    }

    /**
     * @return EasySms
     */
    public function sms()
    {
        $sms = new EasySms(array_merge([
            'timeout' => 5.0,
            'default' => [
                'gateways' => [$this->config->channel],
            ],
            'gateways' => Arr::except($this->config->toArray(), ['type', 'channel']),
        ]));

        logger()->info('sms config', array_merge([
            'timeout' => 5.0,
            'default' => [
                'gateways' => [$this->config->channel],
            ],
            'gateways' => Arr::except($this->config->toArray(), ['type', 'channel']),
        ]));

        $sms->extend('gptlink', function ($config) {
            return new GptlinkGateway($config);
        });

        return $sms;
    }

    public function deleteLoginCache($mobile)
    {
        cache()->delete($this->getLoginKey($mobile));
        cache()->delete($this->getLoginAttemptsKey($mobile));
    }

    /**
     * @param $mobile
     * @return string
     */
    public function getLoginKey($mobile)
    {
        return sprintf('sms_code_login_%s', $mobile);
    }

    /**
     * @param $mobile
     * @return string
     */
    public function getLoginAttemptsKey($mobile)
    {
        return sprintf('sms_code_attempts_login_%s', $mobile);
    }

    /**
     * 发送短信
     *
     * @param $mobilePhone
     * @return int
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    protected function sendCode($mobilePhone)
    {
        $code = mt_rand(1000, 9999);

        $this->sms()->send($mobilePhone, $this->getData($code));

        $this->deleteLoginCache($mobilePhone);

        // 加入缓存时间
        cache()->set($this->getLoginKey($mobilePhone), [
            'code' => $code,
            'lock_at' => time(),
        ], $this->expireAt);

        return $code;
    }
}
