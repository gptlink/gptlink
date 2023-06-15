<?php

namespace App\Http\Dto;

use Cblink\Dto\Dto;
use Hyperf\Utils\Str;

/**
 * @property bool $title 标题
 * @property string $file_url 文件url
 * @property string $content 内容
 * @property int $size 大小
 * @property int $width 宽
 * @property int $height 高
 */
class MaterialDto extends Dto
{
    protected $fillable = ['title', 'file_url', 'size', 'content', 'width', 'height'];

    public function getCreateData()
    {
        [$string, $content] = explode(",", $this->getItem('content'));

        preg_match("/image\/(png|jpg|jpeg)/", $string, $result);

        return [
            'type' => $result[0],
            'title' => $this->getItem('title'),
            'file_url' => strtolower(sprintf('%s.%s', Str::random(32), $result[1])),
            'size' => $this->getItem('size'),
            'format' => $result[1],
            'width' => $this->getItem('width'),
            'height' => $this->getItem('height'),
            'content' => $content,
        ];
    }
}
