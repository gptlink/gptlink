<?php
declare(strict_types=1);

namespace Hyperf\HttpMessage\Server\Connection;

use Hyperf\HttpMessage\Server\Chunk\Chunkable;
use Hyperf\HttpMessage\Server\ConnectionInterface;
use Swoole\Http\Response;

class SwooleConnection implements ConnectionInterface, Chunkable
{
    /**
     * @var Response
     */
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function setHeader($key, $value)
    {
        $this->response->setHeader($key, $value);
    }

    public function write(string $data): bool
    {
        return $this->response->write($data);
    }
}
