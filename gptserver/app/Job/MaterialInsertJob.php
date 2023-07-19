<?php

namespace App\Job;

use App\Http\Dto\MaterialDto;
use App\Http\Service\QiniuService;
use App\Model\Material;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\Arr;

class MaterialInsertJob extends Job
{
    protected $type;

    protected $fileUrl;

    protected $title;

    public function __construct($type, $fileUrl, $title)
    {
        $this->type = $type;
        $this->fileUrl = $fileUrl;
        $this->title = $title;
    }

    public function handle()
    {
        $info = make(QiniuService::class)->getFileInfo($this->fileUrl);

        Material::createByDto(new MaterialDto([
            'type' => $this->type,
            'title' => $this->title,
            'file_url' => $this->fileUrl,
            'size' => Arr::get($info, 'size', 0),
            'format' => Arr::get($info, 'format', ''),
            'width' => Arr::get($info, 'width', 0),
            'height' => Arr::get($info, 'height', 0),
        ]));
    }
}
