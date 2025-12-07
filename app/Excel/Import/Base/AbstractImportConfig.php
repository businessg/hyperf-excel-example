<?php

declare(strict_types=1);

namespace App\Excel\Import\Base;

use Vartruexuan\HyperfExcel\Data\Import\ImportConfig;

abstract class AbstractImportConfig extends ImportConfig
{
    /**
     * 是否异步
     *
     * @var bool
     */
    public bool $isAsync = true;
}

