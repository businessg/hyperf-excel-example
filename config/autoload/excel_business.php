<?php

declare(strict_types=1);

return [
    // 导出配置
    'export' => [
        // Demo数据导出（异步）
        'demoExport' => [
            'config' => \App\Excel\Export\DemoExportConfig::class,
        ],
        // Demo数据导出（异步）
        'demoAsyncExport' => [
            'config' => \App\Excel\Export\DemoAsyncExportConfig::class,
        ],
        // Demo导入模板导出
        'demoImportTemplate' => [
            'config' => \App\Excel\Export\DemoImportTemplateExportConfig::class,
        ],
    ],
    // 导入配置
    'import' => [
        // Demo数据导入
        'demoImport' => [
            'config' => \App\Excel\Import\DemoImportConfig::class,
            // 基础信息
            'info' => [
                // 模版业务ID（用于下载模板）
                'templateBusinessId' => 'demoImportTemplate',
            ],
        ],
    ],
];

