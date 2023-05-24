<?php

namespace App\Http\Control\Web;

use App\Http\Request\MaterialIndexRequest;
use App\Http\Resource\Admin\MaterialCollection;
use App\Model\Material;
use Cblink\HyperfExt\BaseController;

class MaterialController extends BaseController
{
    /**
     * 素材列表
     *
     * @param MaterialIndexRequest $request
     * @return MaterialCollection
     */
    public function index(MaterialIndexRequest $request)
    {
        $materials = Material::query()
            ->search([
                'type' => ['type' => 'eq']
            ])
            ->orderByDesc('created_at')->page();

        return new MaterialCollection($materials);
    }
}
