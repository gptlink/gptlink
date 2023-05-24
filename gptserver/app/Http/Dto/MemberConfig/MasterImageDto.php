<?php

namespace App\Http\Dto\MemberConfig;

use Cblink\Dto\Dto;

/**
 * @property integer $type
 * @property integer $member_id
 * @property string $master_image 大师形象
 */
class MasterImageDto extends Dto implements MemberConfigDtoInterface
{
    protected $fillable = [
        'master_image', 'type', 'member_id'
    ];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'type' => $this->getItem('type'),
            'master_image' => $this->getItem('master_image'),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'master_image' => $this->getItem('master_image'),
            ]
        ];
    }

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array
    {
        return [
            'member_id' => $this->getItem('member_id'),
            'type' => $this->getItem('type'),
        ];
    }
}
