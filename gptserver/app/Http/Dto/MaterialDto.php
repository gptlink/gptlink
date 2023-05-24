<?php

namespace App\Http\Dto;

use App\Base\Consts\ModelConst;
use App\Http\Service\ChatGPTService;
use Carbon\Carbon;
use Cblink\Dto\Dto;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * @property string $type 素材类型
 * @property bool $title 标题
 * @property string $file_url 文件url
 * @property int $size  大小
 * @property string $format 后缀
 * @property int $width 宽
 * @property int $height 高
 */
class MaterialDto extends Dto
{
    protected $fillable = ['type', 'title', 'file_url', 'size', 'format', 'width', 'height'];

    public function getCreateData()
    {
        return [
            'type' => $this->getItem('type'),
            'title' => $this->getItem('title'),
            'file_url' => $this->getItem('file_url'),
            'size' => $this->getItem('size'),
            'format' => $this->getItem('format'),
            'width' => $this->getItem('width'),
            'height' => $this->getItem('height'),
        ];
    }
}
