<?php

namespace App\Http\Dto;

use Cblink\Dto\Dto;

/**
 * @property string $name 分组名称
 * @property int $num CDK生成数量
 * @property int $package_id 套餐包ID
 * @property int $price 价格
 * @property string $remark 备注
 */
class CdkGroupDto extends Dto
{
    protected $fillable = [
        'name', 'num', 'package_id', 'remark'
    ];

    /**
     * @return array
     */
    public function createData(): array
    {
        return [
            'name' => $this->getItem('name'),
            'package_id' => $this->getItem('package_id'),
            'num' => $this->getItem('num'),
            'remark' => $this->getItem('remark'),
        ];
    }

    public function updateData()
    {
        return [
            'name' => $this->getItem('name'),
            'remark' => $this->getItem('remark'),
        ];
    }

}
