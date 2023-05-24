<?php

namespace App\Http\Control\Admin;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Request\Admin\MaterialRequest;
use App\Http\Request\MaterialIndexRequest;
use App\Http\Resource\Admin\MaterialCollection;
use App\Http\Resource\Admin\MaterialResource;
use App\Http\Service\QiniuService;
use App\Job\MaterialInsertJob;
use App\Model\ChatGptModel;
use App\Model\Material;
use Cblink\HyperfExt\BaseController;
use Hyperf\Utils\Arr;

class MaterialController extends BaseController
{
    /**
     * @param MaterialIndexRequest $request
     * @return MaterialCollection
     */
    public function index(MaterialIndexRequest $request)
    {
        $materials = Material::query()
            ->where([
                'type' => $request->input('type')
            ])
            ->orderByDesc('created_at')->pageOrAll();

        return new MaterialCollection($materials);
    }

    /**
     * 创建
     *
     * @param MaterialRequest $request
     * @param QiniuService $qiniuService
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store(MaterialRequest $request)
    {
        $type = $request->input('type');
        foreach ($request->input('files') as $file) {
            asyncQueue(new MaterialInsertJob(
                    $type,
                    Arr::get($file, 'file_url'),
                    Arr::get($file, 'title')
                )
            );
        }
        return $this->success();
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function destroy($id)
    {
        $material = Material::query()->findOrFail($id);
        $exists = ChatGptModel::query()->where(['icon' => $material->file_url])->exists();
        throw_if($exists, LogicException::class, ErrCode::MATERIAL_MODEL_EXISTS);
        $material->delete();
        return $this->success();
    }
}
