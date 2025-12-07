<?php

declare(strict_types=1);

namespace App\Excel\Export\Base;

use Vartruexuan\HyperfExcel\Data\Export\ExportConfig;

abstract class AbstractExportConfig extends ExportConfig
{
    public string $outPutType = self::OUT_PUT_TYPE_UPLOAD;
    
    /**
     * 是否异步
     *
     * @var bool
     */
    public bool $isAsync = true;
}

