<?php

declare(strict_types=1);

return [
    'default' => 'xlswriter',
    'drivers' => [
        'xlswriter' => [
            'class' => \BusinessG\BaseExcel\Driver\XlsWriterDriver::class,
            'disk' => 'local',
            'exportDir' => 'export',
            'tempDir' => null,
        ],
    ],
    'logging' => [
        'channel' => 'hyperf-excel',
    ],
    'queue' => [
        'connection' => 'default',
        'channel' => 'default',
    ],
    'progress' => [
        'enabled' => true,
        'prefix' => 'HyperfExcel',
        'ttl' => 3600,
        'connection' => 'default',
    ],
    'dbLog' => [
        'enabled' => true,
        'model' => \BusinessG\HyperfExcel\Db\Model\ExcelLog::class,
    ],
    'cleanup' => [
        'enabled' => true,
        'maxAge' => 1800,
        'interval' => 3600,
    ],
    'http' => [
        'enabled' => true,
        'prefix' => '',
        'middleware' => [],
        'domain' => \Hyperf\Support\env('APP_URL', 'http://localhost:9501'),
        'codeField' => 'code',
        'dataField' => 'data',
        'messageField' => 'message',
        'successCode' => 0,
    ],
];
