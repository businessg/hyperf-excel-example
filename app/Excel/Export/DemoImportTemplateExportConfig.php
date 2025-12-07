<?php

declare(strict_types=1);

namespace App\Excel\Export;

use App\Excel\Export\Base\AbstractExportConfig;
use Vartruexuan\HyperfExcel\Data\Export\Column;
use Vartruexuan\HyperfExcel\Data\Export\Sheet;
use Vartruexuan\HyperfExcel\Data\Export\Style;

class DemoImportTemplateExportConfig extends AbstractExportConfig
{
    public string $serviceName = 'Demo数据导入模板';

    public bool $isAsync = false;

    public string $outPutType = self::OUT_PUT_TYPE_UPLOAD;

    public function getSheets(): array
    {
        $this->setSheets([
            new Sheet([
                'name' => '导入模板',
                'columns' => [
                    new Column([
                        'title' => implode("\n", [
                            '1、姓名：必填，字符串类型',
                            '2、邮箱：必填，必须是有效的邮箱格式',
                            '3、请按照模板格式填写数据'
                        ]),
                        'field' => 'name',
                        'height' => 58,
                        'headerStyle' => new Style([
                            'wrap' => true,
                            'fontColor' => 0x2972F4,
                            'font' => '等线',
                            'align' => [Style::FORMAT_ALIGN_LEFT, Style::FORMAT_ALIGN_VERTICAL_CENTER],
                            'fontSize' => 10,
                            'bold' => true,
                        ]),
                        'children' => [
                            new Column([
                                'title' => '姓名',
                                'field' => 'name',
                                'width' => 32,
                                'headerStyle' => new Style([
                                    'align' => [Style::FORMAT_ALIGN_CENTER],
                                    'bold' => true,
                                ])
                            ]),
                            new Column([
                                'title' => '邮箱',
                                'field' => 'email',
                                'width' => 40,
                                'headerStyle' => new Style([
                                    'align' => [Style::FORMAT_ALIGN_CENTER],
                                    'bold' => true,
                                ])
                            ]),
                        ],
                    ]),
                ],
                'count' => 0,
                'data' => [],
                'pageSize' => 1,
            ])
        ]);
        return $this->sheets;
    }
}

