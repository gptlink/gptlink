<?php

namespace App\Http\Service;

use App\Model\Cdk;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Response;
use Hyperf\Utils\Arr;
use Hyperf\Utils\Collection;
use Hyperf\Utils\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * excel数据处理服务
 */
class ExcelService
{
    /**
     * @var array excel表头
     */
    protected $headers;

    /**
     * @var array excel数据
     */
    protected $data;

    /**
     * @var string excel文件名
     */
    protected $filename;

    /**
     * 设置excel表头
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * 设置excel数据
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * 设置导出excel文件名
     * @param string $filename
     */
    public function setFilename(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * 导出excel
     * @param mixed $filename
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export($filename, array $headers = [], array $data = [])
    {
        // 创建 Excel 文件对象
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 设置表头
        $columnIndex = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
            $columnIndex++;
        }

        // 填充数据
        $rowIndex = 2;
        foreach ($data as $rowData) {
            $columnIndex = 1;
            foreach ($rowData as $cellData) {
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellData);
                $columnIndex++;
            }
            $rowIndex++;
        }

        // 输出 Excel 文件
        /* @var Xlsx $writer */
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $savePATH = BASE_PATH . '/runtime/export/';

        if (! file_exists($savePATH)) {
            mkdir($savePATH);
        }

        // 保存到服务器的临时文件下
        $writer->save($cacheName = $savePATH . Str::random());

        // 将文件转字符串供流读取
        $content = file_get_contents($cacheName);

        $response = new Response();
        $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        // 删除临时文件
        unlink($cacheName);

        return $response->withHeader('content-description', 'File Transfer')
            ->withHeader('content-type', $contentType)
            ->withHeader('content-disposition', "attachment; filename={$filename}.xlsx")
            ->withHeader('content-transfer-encoding', 'binary')
            ->withHeader('pragma', 'public')
            ->withBody(new SwooleStream((string) $content));
    }

    /**
     * 格式化导出数据
     * @param Cdk[]|Collection $originData
     * @return array|mixed
     */
    public function formatData(Collection $originData)
    {
        return $originData->map(function ($cdk) {
            return [
                'id' => $cdk['id'],
                'package_name' => Arr::get($cdk, 'package.name'),
                'num' => Arr::get($cdk, 'package.num') . '次',
                'code' => $cdk['code'],
                'nickname' => Arr::get($cdk, 'member.nickname', ''),
                'mobile' => Arr::get($cdk, 'member.mobile', ''),
                'updated_at' => $cdk['updated_at'],
                'status' => Cdk::STATUS[$cdk['status']],
            ];
        })->toArray();
    }
}
