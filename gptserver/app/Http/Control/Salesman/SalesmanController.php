<?php

namespace App\Http\Control\Salesman;

use App\Http\Dto\Config\SalesmanDto;
use App\Model\Config;
use App\Model\Member;
use App\Model\SalesmanOrder;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;

class SalesmanController extends BaseController
{

    /**
     * 获取余额
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function balance()
    {
        return $this->success([
            'balance' => auth()->user()->balance,
        ]);
    }

    /**
     * 统计
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function statistics()
    {
        /* @var SalesmanDto $dto */
        $dto  = Config::toDto(Config::SALESMAN);

        return $this->success([
            'order_num' => SalesmanOrder::query()->where('user_id', auth()->id())->count(),
            'order_price' => SalesmanOrder::query()->where('user_id', auth()->id())->sum('price'),
            'custom_num' => Member::query()->where('parent_openid', auth()->user()->code)->count(),
            'balance' => auth()->user()->balance,
            'ratio' => (auth()->user()->ratio > 0 ? auth()->user()->ratio : $dto->ratio),
        ]);
    }

}
