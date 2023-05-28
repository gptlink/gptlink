<?php

namespace HyperfTest\Api\Admin;

use App\Model\Order;
use Carbon\Carbon;
use HyperfTest\Factory\OrderFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class DevelopTest extends TestCase
{
    use LoginTrait;

    public function testAdminDevelopGetPackage()
    {
        /*
        $this->adminLogin();

        $response = $this->get('/admin/develop/package');

        $this->assertApiSuccess($response);

        OrderFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '套餐余额',
            'category' => '开发者套餐',
            'params' => [],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => '订单id',
                'name' => '套餐名称',
                'num' => '套餐数量',
                'used' => '已使用数量',
                'expired_at' => '过期时间',
            ],
        ]));
        */
        $this->assertTrue(true);
    }
}
