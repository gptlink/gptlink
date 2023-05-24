<?php

namespace HyperfTest\Api\Admin;

use App\Base\Consts\StatisticsConst;
use App\Model\Order;
use Carbon\Carbon;
use HyperfTest\Factory\MemberFactory;
use HyperfTest\Factory\OrderFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class StatisticsTest extends TestCase
{
    use LoginTrait;

    public function testAdminStatistics()
    {
        $this->adminLogin();

        $userId = 1;
        $packageId = 1;
        OrderFactory::createByData(['user_id' => $userId, 'package_id' => $packageId]);
        OrderFactory::createByData(['user_id' => $userId, 'package_id' => $packageId]);

        MemberFactory::createByData();

        $response = $this->get('/admin/statistics/count', [
            'type' => [StatisticsConst::MEMBER_COUNT, StatisticsConst::PAYMENT_COUNT],
        ]);

        $this->assertApiSuccess($response);

        OrderFactory::truncate();
        MemberFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '公共统计查询',
            'category' => '统计',
            'params' => [],
            'desc' => '',
            'request' => [
                'type' => BaseDto::mapDesc('统计类型', StatisticsConst::STATISTICS_TYPE)
            ],
            'request_except' => [],
            'response' => [
                'member_count' => '会员数量',
                'payment_count' => '支付总额',
            ],
        ]));
    }
}
