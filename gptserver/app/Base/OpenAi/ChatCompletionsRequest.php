<?php

namespace App\Base\OpenAi;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\ChatDto;
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

    public $result;

    /**
     * @var ChatDto
     */
    public $dto;

    public function __construct(ChatDto $dto)
    {
        $this->dto = $dto;
        $this->data = json_encode($dto->getPayload(), JSON_UNESCAPED_UNICODE);
        $this->headers = [
            'Accept' => 'text/event-stream',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . DevelopService::getApikey(),
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

        // 如果没有json错误，则表示返回的是json
        if (! json_last_error()) {
            switch ($data['err_code']){
                case ErrCode::MEMBER_INSUFFICIENT_BALANCE:
                    throw new LogicException(ErrCode::SYSTEM_INSUFFICIENT_BALANCE);
                default:
                    throw new LogicException($data['err_code']);
            }
        }
    }
}
