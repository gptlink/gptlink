<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\Dto\Dto;

/**
 * @property string $channel  渠道
 * @property string $default_system_prompt 默认系统咒语
 * @property string $gptlink_key gptlink key
 * @property string $openai_key openai key
 * @property string $openai_model openai model
 * @property int|string $openai_tokens 最大tokens
 * @property int $openai_response_tokens 返回最大tokens
 * @property string $openai_host 请求地址
 * @property string $openai_proxy_host 代理地址
 * @property string $azure_endpoint
 * @property string $azure_model
 * @property string $azure_key
 * @property string $azure_api_version
 */
class AiChatConfigDto extends Dto implements ConfigDtoInterface
{
    const GPTLINK = 'gptlink';
    const OPENAI = 'openai';

    protected $fillable = [
        'type',
        'channel',
        'default_system_prompt',
        'gptlink_key',
        'openai_key', 'openai_model', 'openai_tokens', 'openai_response_tokens', 'openai_host', 'openai_proxy_host',
        'azure_endpoint', 'azure_model', 'azure_key', 'azure_api_version',
    ];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'type' => $this->getItem('type'),
            'channel' => $this->getItem('channel'),
            'default_system_prompt' => $this->getItem('default_system_prompt'),
            'gptlink_key' => $this->getItem('gptlink_key'),
            'openai_key' => $this->getItem('openai_key'),
            'openai_model' => $this->getItem('openai_model'),
            'openai_tokens' => $this->getItem('openai_tokens'),
            'openai_response_tokens' => $this->getItem('openai_response_tokens'),
            'openai_host' => $this->getItem('openai_host'),
            'openai_proxy_host' => $this->getItem('openai_proxy_host'),
            'azure_endpoint' => $this->getItem('azure_endpoint'),
            'azure_model' => $this->getItem('azure_model'),
            'azure_key' => $this->getItem('azure_key'),
            'azure_api_version' => $this->getItem('azure_api_version'),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'channel' => $this->getItem('channel'),
                'default_system_prompt' => $this->getItem('default_system_prompt'),
                'gptlink_key' => $this->getItem('gptlink_key'),
                'openai_key' => $this->getItem('openai_key'),
                'openai_model' => $this->getItem('openai_model'),
                'openai_tokens' => $this->getItem('openai_tokens'),
                'openai_response_tokens' => $this->getItem('openai_response_tokens'),
                'openai_host' => $this->getItem('openai_host'),
                'openai_proxy_host' => $this->getItem('openai_proxy_host'),
                'azure_endpoint' => $this->getItem('azure_endpoint'),
                'azure_model' => $this->getItem('azure_model'),
                'azure_key' => $this->getItem('azure_key'),
                'azure_api_version' => $this->getItem('azure_api_version'),
            ]
        ];
    }

    /**
     * @return string
     */
    public function getOpenAiKey()
    {
        $keys = explode("\n", $this->getItem('openai_key'));

        return $keys[array_rand($keys)];
    }

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array
    {
        return [
            'type' => $this->getItem('type', Config::AI_CHAT),
        ];
    }
}
