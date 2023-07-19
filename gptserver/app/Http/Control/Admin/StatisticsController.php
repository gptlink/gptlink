<?php

namespace App\Http\Control\Admin;

use App\Base\Consts\StatisticsConst;
use App\Http\Request\Admin\StatisticsRequest;
use App\Http\Service\StatisicsService;
use Cblink\HyperfExt\BaseController;
use Hyperf\Utils\Arr;

class StatisticsController extends BaseController
{
    /**
     * 获取统计信息
     * @param StatisticsRequest $request
     * @param StatisicsService $service
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(StatisticsRequest $request, StatisicsService $service)
    {
        $data = [];
        $types = array_flip($request->input('type', [])); // 交互数组的键和值

        if (Arr::only($types, [StatisticsConst::MEMBER_COUNT])) {
            $method = StatisticsConst::STATISTICS_METHOD[StatisticsConst::MEMBER_COUNT];
            $data['member_count'] = $service->{$method}();
        }

        if (Arr::only($types, [StatisticsConst::PAYMENT_COUNT])) {
            $method = StatisticsConst::STATISTICS_METHOD[StatisticsConst::PAYMENT_COUNT];
            $data['payment_count'] = $service->{$method}();
        }

        return $this->success($data);
    }
}
