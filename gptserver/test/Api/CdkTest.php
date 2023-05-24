<?php

namespace HyperfTest\Api;

use App\Model\Cdk;
use App\Model\Package;
use HyperfTest\Factory\PackageFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class CdkTest extends TestCase
{
    use LoginTrait;

    public function testCdkExchange()
    {
        $user = $this->userLogin();

        $package = PackageFactory::createByData();

        $cdk = Cdk::generate($package->id);

        $response = $this->post('/cdk', [
            'cdk' => $cdk->code,
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '兑换套餐',
            'category' => '兑换码',
            'desc' => '',
            'params' => [],
            'request' => [
                'cdk' => 'cdk码',
            ],
            'request_except' => [],
            'response' => [
                'id' => '套餐ID',
                'name' => '套餐名称',
                'type' => BaseDto::mapDesc('套餐类型', Package::TYPE),
                'expired_day' => '过期时间，单位天，0表示2099年过期',
                'num' => '套餐内次数，-1表示不限制',
                'price' => '价值',
            ],
        ]));
    }
}
