<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use App\Exception\ChatgptException;
use App\Exception\ErrCode;
use App\Exception\FailReturnException;
use App\Exception\RemoteException;
use App\Exception\Traits\ExceptionHandlerTrait;
use App\Exception\UserDisableException;
use Cblink\HyperfExt\Traits\CorsTrait;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\ValidationException;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Psr\Http\Message\ResponseInterface;
use Qbhy\HyperfAuth\Exception\AuthException;

class AppExceptionHandler extends ExceptionHandler
{
    use ExceptionHandlerTrait, CorsTrait;

    protected $expectExceptions = [
        AuthException::class,
        HttpException::class,
        UserDisableException::class,
        FailReturnException::class,
    ];

    public function handle(\Throwable $throwable, ResponseInterface $response)
    {
        $response = $this->corsResponse($request = make(RequestInterface::class), $response);

        // 记录错误日志
        if (! $this->shouldntReport($throwable)) {
            $this->logger($throwable, $request);
        }

        if ($throwable instanceof ChatgptException) {
            return $this->error($response, $throwable->getCode(), $throwable->getMessage());
        }

        // 请求远程内容出现错误
        if ($throwable instanceof RemoteException) {
            return $this->error($response, $throwable->getCode(), $throwable->getErrMsg(), [
                'remote' => $throwable->getThirdType(),
                'remote_err_code' => $throwable->getErrCode(),
                'remote_err_msg' => $throwable->getMessage(),
            ]);
        }

        if ($throwable instanceof NoGatewayAvailableException) {
            return $this->error($response, ErrCode::SMS_SEND_FAIL);
        }

        if ($throwable instanceof AuthException) {
            return $this->error($response, ErrCode::AUTHENTICATION);
        }

        if ($throwable instanceof ValidationException) {
            return $this->error($response, ErrCode::VALIDATE_ERR, $throwable->validator->errors()->first());
        }

        if ($throwable instanceof HttpException) {
            return $this->error($response, $throwable->getStatusCode());
        }

        if ($throwable instanceof ModelNotFoundException) {
            return $this->error($response, ErrCode::MODEL_NOT_FOUND);
        }

        if ($throwable instanceof FailReturnException) {
            return $this->error($response, $throwable->getCode(), '', [
                'data' => json_decode($throwable->getMessage(), true),
            ]);
        }

        $payload = config('app_debug', false) ?
            ['exception' => [
                'message' => $this->getMessage($throwable),
                'trace' => $throwable->getTraceAsString(),
            ],]: [];

        return $this->error($response, $this->getDefaultCode($throwable), '', $payload);
    }

    /**
     * @return bool
     */
    public function shouldntReport(\Throwable $throwable)
    {
        foreach ($this->expectExceptions as $exception) {
            if ($throwable instanceof $exception) {
                return true;
            }
        }

        return false;
    }

    public function isValid(\Throwable $throwable): bool
    {
        return true;
    }
}
