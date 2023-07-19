<?php

declare(strict_types=1);

namespace App\Exception;

class RemoteException extends \RuntimeException
{
    public $errCode;

    public $thirdType;

    public function __construct(string $message = '', $code = 0, $thirdType = 'third')
    {
        parent::__construct($message, ErrCode::BAD_REQUEST);
        $this->errCode = $code;
        $this->thirdType = $thirdType;
    }

    /**
     * @return int|mixed
     */
    public function getErrCode()
    {
        return $this->errCode;
    }

    /**
     * @return string
     */
    public function getErrMsg()
    {
        return $this->getMessage();
    }

    /**
     * @return mixed|string
     */
    public function getThirdType()
    {
        return $this->thirdType;
    }
}
