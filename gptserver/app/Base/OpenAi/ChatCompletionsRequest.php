<?php

namespace App\Base\OpenAi;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\ChatDto;
use App\Http\Dto\Config\AiChatConfigDto;
use App\Http\Service\ChatGPTService;
use App\Http\Service\DevelopService;
use Swoole\Http2\Request;

class ChatCompletionsRequest extends Request implements RequestInterface
{
    public $path = '/v1/chat/completions';

    public $method = 'POST';

    public $headers;

    public $cookies;

    public $data = '';

    public $pipeline = false;

    public $debug;

    public $result;

    /**
     * @var ChatDto
     */
    public $dto;

    /**
     * @var AiChatConfigDto
     */
    public $config;

    public function __construct(ChatDto $dto, AiChatConfigDto $config)
    {
        $this->dto = $dto;
        $this->config = $config;
        $this->data = json_encode($dto->toGPTLink($config), JSON_UNESCAPED_UNICODE);
        $this->headers = [
            'Accept' => 'text/event-stream',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $config->gptlink_key,
        ];
    }

    /**
     * 发送请求
     *
     * @param OpenAIClient $client
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function send(OpenAIClient $client): mixed
    {
        $client->send($this);

        $payload = $this->read($client, 5);

        $this->jsonDebug($payload->data);

        while (! empty($resultData = $payload->data)) {
            $matches = [];

            preg_match_all("/data:\\s(.*)\n\n/", $resultData, $matches);

            if (! isset($matches[1])) {
                continue;
            }

            foreach ($matches[1] as $item) {
                $result = json_decode($item, true);

                // 用户中断请求会失败，所以做了处理
                if (! $client->response()->write(sprintf('%s%s%s', $this->dto->formatBefore(), $item, $this->dto->formatAfter()))) {
                    $this->result = $result;
                    return $this;
                }
            }

            $payload = $this->read($client, 5, 0);
        }

        $client->close();

        $this->result = $result ?? [];

        return $this;
    }

    /**
     * @param OpenAIClient $client
     * @param null $timeout
     * @return mixed
     */
    public function read(OpenAIClient $client, $timeout = null)
    {
        return $client->read($timeout);
    }

    /**
     * 增加日志记录
     *
     * @param $data
     */
    public function jsonDebug($data)
    {
        $data = json_decode($data, true);

        $this->debug = $data;

        // 如果没有json错误，则表示返回的是json
        if (! json_last_error()) {
            switch ($data['err_code']){
                case ErrCode::MEMBER_INSUFFICIENT_BALANCE:
                    throw new LogicException(ErrCode::SYSTEM_INSUFFICIENT_BALANCE);
                case ErrCode::AUTHENTICATION:
                    throw new LogicException(ErrCode::SYSTEM_KEY_INVALID);
            }
        }
    }
}
