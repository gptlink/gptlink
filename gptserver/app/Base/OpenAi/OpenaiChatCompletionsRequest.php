<?php

namespace App\Base\OpenAi;

use App\Http\Dto\ChatDto;
use App\Http\Dto\Config\AiChatConfigDto;
use Hyperf\Utils\Arr;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Swoole\Http2\Request;

class OpenaiChatCompletionsRequest extends Request implements RequestInterface
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
        $this->data = json_encode($dto->toOpenAi($config), JSON_UNESCAPED_UNICODE);
        $this->headers = [
            'Accept' => 'text/event-stream',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $config->getOpenAiKey(),
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

        $text = '';

        $this->jsonDebug($payload->data);

        while (! empty($resultData = $payload->data)) {
            $matches = [];

            preg_match_all("/data:\\s(.*)\n\n/", $resultData, $matches);

            if (! isset($matches[1])) {
                continue;
            }

            foreach ($matches[1] as $item) {
                $data = json_decode($item, true);

                if (! is_null(Arr::get($data, 'choices.0.delta.content'))) {
                    $text .= Arr::get($data, 'choices.0.delta.content', '');

                    $result = [
                        'id' => $data['id'],
                        'model' => $data['model'],
                        'messages' => $text,
                        'created' => $data['created'],
                    ];

                    // 用户中断请求会失败，所以做了处理
                    if (! $client->response()->write(sprintf('%s%s%s', $this->dto->formatBefore(), json_encode($result, JSON_UNESCAPED_UNICODE), $this->dto->formatAfter()))) {
                        $this->result = $result;
                        return $this;
                    }
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
     * @param int $retry
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function read(OpenAIClient $client, $timeout = null, int $retry = 3)
    {
        $payload = $client->read($timeout);

        if (! $payload && $retry > 0) {
            logger('exception')->info('重试发送请求', [
                'req' => $this->data,
                'retry' => $retry,
            ]);

            $client->reconnect()->send($this);

            return $this->read($client, $timeout, $retry - 1);
        }

        return $payload;
    }

    /**
     * 增加日志记录
     *
     * @param $data
     */
    public function jsonDebug($data)
    {
        json_decode($data, true);

        if (! json_last_error()) {
            $this->debug = $data;
        }
    }
}
