<?php

declare(strict_types=1);

namespace App\Excel\Export;

use App\Excel\Export\Base\AbstractExportConfig;
use Vartruexuan\HyperfExcel\Data\Export\Column;
use Vartruexuan\HyperfExcel\Data\Export\ExportCallbackParam;
use Vartruexuan\HyperfExcel\Data\Export\Sheet;

class DemoAsyncExportConfig extends AbstractExportConfig
{
    public string $serviceName = 'Demo数据导出（异步）';

    public  string $outPutType=self::OUT_PUT_TYPE_UPLOAD;
    /**
     * 是否异步 - 强制设置为异步
     */
    public bool $isAsync = true;

    public function getSheets(): array
    {
        $this->setSheets([
            new Sheet([
                'name' => 'sheet1',
                'columns' => [
                    new Column([
                        'title' => 'ID',
                        'field' => 'id',
                    ]),
                    new Column([
                        'title' => '姓名',
                        'field' => 'name',
                    ]),
                    new Column([
                        'title' => '邮箱',
                        'field' => 'email',
                    ]),
                    new Column([
                        'title' => '创建时间',
                        'field' => 'created_at',
                    ]),
                ],
                'count' => $this->getDataCount(),
                'data' => [$this, 'getData'],
                'pageSize' => 1000,
            ])
        ]);
        return $this->sheets;
    }

    /**
     * 获取数据数量
     *
     * @return int
     */
    public function getDataCount(): int
    {
        // 模拟数据，实际应该从数据库或服务获取
        $params = $this->getParams();
        // 这里返回模拟的数据总数，设置为较大的值以便测试进度条
        return 50000;
    }

    /**
     * 获取数据
     *
     * @param ExportCallbackParam $exportCallbackParam
     * @return array
     */
    public function getData(ExportCallbackParam $exportCallbackParam): array
    {
        // 模拟数据，实际应该从数据库或服务获取
        $params = $this->getParams();
        $page = $exportCallbackParam->page;
        $pageSize = $exportCallbackParam->pageSize;
        
        // 延迟 600ms，模拟数据查询耗时
        usleep(600000); // 600000 微秒 = 600 毫秒
        
        // 生成模拟数据
        $data = [];
        $totalCount = $this->getDataCount();
        for ($i = 0; $i < $pageSize; $i++) {
            $index = ($page - 1) * $pageSize + $i + 1;
            if ($index > $totalCount) {
                break;
            }
            $data[] = [
                'id' => $index,
                'name' => '用户' . $index,
                'email' => 'user' . $index . '@example.com',
                'created_at' => date('Y-m-d H:i:s', time() - rand(0, 86400 * 30)),
            ];
        }
        
        return $data;
    }
}
