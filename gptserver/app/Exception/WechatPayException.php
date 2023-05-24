<?php

namespace App\Exception;

class WechatPayException extends RemoteException
{
    /**
     * @var array
     */
    protected $translate = [];

    /**
     * @var array
     */
    protected $translateMessage = [
        'sub_mch_id与sub_appid不匹配' => '小程序尚未绑定授权的收款商户号',
    ];

    public function getErrMsg()
    {
        if (array_key_exists($this->getErrCode(), $this->translate)) {
            return $this->translate[$this->getErrCode()];
        }

        if (array_key_exists($this->getMessage(), $this->translateMessage)) {
            return $this->translateMessage[$this->getMessage()];
        }

        return $this->getMessage();
    }
}
