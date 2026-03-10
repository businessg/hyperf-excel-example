<?php

declare(strict_types=1);

return [
    'export' => [
        'demoExport' => [
            'config' => \BusinessG\BaseExcel\Demo\DemoExportConfig::class,
        ],
        'demoExportOut' => [
            'config' => \BusinessG\BaseExcel\Demo\DemoExportOutConfig::class,
        ],
        'demoAsyncExport' => [
            'config' => \BusinessG\BaseExcel\Demo\DemoAsyncExportConfig::class,
        ],
        'demoExportForImport' => [
            'config' => \BusinessG\BaseExcel\Demo\DemoExportForImportConfig::class,
        ],
        'demoImportTemplate' => [
            'config' => \BusinessG\BaseExcel\Demo\DemoImportTemplateExportConfig::class,
        ],
    ],
    'import' => [
        'demoImport' => [
            'config' => \BusinessG\BaseExcel\Demo\DemoImportConfig::class,
            'info' => [
                'templateBusinessId' => 'demoImportTemplate',
            ],
        ],
    ],
];
