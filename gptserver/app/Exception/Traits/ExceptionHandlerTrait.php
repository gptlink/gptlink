<?php

declare(strict_types=1);

namespace App\Exception\Traits;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\ValidationException;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Psr\Http\Message\ResponseInterface;

trait ExceptionHandlerTrait
{
    /**
     * 返回错误信息.
     *
     * @param ResponseInterface $response
     * @param int $errCode
     * @param string $message
     * @param array $payload
     * @return ResponseInterface
     */
    public function error(ResponseInterface $response, int $errCode = ErrCode::UNKNOWN, string $message = '', array $payload = [])
    {
        $body = array_merge($payload, [
            'err_code' => $errCode,
            'err_msg' => ! empty($message) ? $message : ErrCode::getMessage($errCode),
        ]);

        $stream = new SwooleStream(json_encode($body));

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($stream);
    }

    /**
     * @param \Throwable $throwable
     * @return int
     */
    public function getDefaultCode(\Throwable $throwable)
    {
        if (is_int($throwable->getCode()) && $throwable->getCode() != 0) {
            return $throwable->getCode();
        }

        return 500;
    }

    /**
     * 记录日志.
     * @param \Throwable $throwable
     * @param RequestInterface $request
     * @return false|void
     */
    public function logger(\Throwable $throwable, $request)
    {
        logger('exception')->info('exception', [
            'req' => $request->all(),
            'url' => sprintf('%s %s', $request->getMethod(), $request->fullUrl()),
            'message' => $this->getMessage($throwable),
            'trace' => $throwable->getTraceAsString(),
        ]);
    }

    public function getMessage(\Throwable $throwable)
    {
        $message = sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile());

        if ($throwable instanceof ValidationException) {
            $message = $throwable->validator->errors()->all();
        }

        if ($throwable instanceof NoGatewayAvailableException) {
            $message = $throwable->getExceptions();
        }

        if ($throwable instanceof LogicException) {
            $message = sprintf('errcode %s', $throwable->getCode());

            if (auth()->check()) {
                $message .= sprintf(', user_id: %s', auth()->id());
            }
        }

        return $message;
    }
}
