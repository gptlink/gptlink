<?php

namespace App\Http\Dto\Config;

use App\Model\Config;
use Cblink\HyperfExt\Dto;

/**
 * @property bool $enable 是否开启分销
 * @property bool $open   开放申请
 * @property string $rules 规则说明
 * @property int $ratio 佣金比例
 */
class SalesmanDto extends Dto implements ConfigDtoInterface
{
    protected $fillable = ['type', 'enable', 'open', 'rules', 'ratio'];

    /**
     * 默认数据
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return [
            'enable' => $this->getItem('enable', false),
            'open' => $this->getItem('open', false),
            'rules' => $this->getItem('rules'),
            'ratio' => $this->getItem('ratio'),
        ];
    }

    /**
     * 更新或创建时的数据.
     */
    public function getConfigFillable(): array
    {
        return [
            'config' => [
                'enable' => $this->getItem('enable', false),
                'open' => $this->getItem('open', false),
                'rules' => $this->getItem('rules'),
                'ratio' => $this->getItem('ratio'),
            ]
        ];
    }

    /**
     * 唯一标识数据.
     */
    public function getUniqueFillable(): array
    {
        return [
            'type' => $this->getItem('type', Config::SALESMAN),
        ];
    }
}
