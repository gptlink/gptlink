<?php

declare(strict_types=1);

namespace HyperfTest\Factory;

use App\Http\Dto\BusinessDto;
use App\Http\Dto\MaterialDto;
use App\Model\Material;

class MaterialFactory
{
    /**
     * @param array $payload
     */
    public static function createByDto(array $payload = [])
    {
       return Material::createByDto(new MaterialDto(array_merge([
            'type' => Material::TYPE_MASTER_IMAGE,
            'title' => 'ai_test',
            'file_url' => 'https://cdn.gpt-link.com/ai/2023-04-26/fdaa9df8e6c469bc17a9789dfdb1d511.png',
            'size' => 50,
            'format' => 'png',
            'width' => 768,
            'height' => 768,
		],$payload)));
    }

	public static function destory($id)
	{
        Material::query()->where(['id' => $id])->delete();
	}
}
