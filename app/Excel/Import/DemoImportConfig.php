<?php

declare(strict_types=1);

namespace App\Excel\Import;

use App\Excel\Import\Base\AbstractImportConfig;
use App\Exception\BusinessException;
use Hyperf\Collection\Arr;
use Hyperf\Context\ApplicationContext;
use Vartruexuan\HyperfExcel\Data\Import\ImportRowCallbackParam;
use Vartruexuan\HyperfExcel\Data\Import\Sheet;
use Vartruexuan\HyperfExcel\Data\Import\Column;
use Vartruexuan\HyperfExcel\Progress\ProgressInterface;

class DemoImportConfig extends AbstractImportConfig
{
    public string $serviceName = 'Demo数据导入';

    protected array $importedData = [];

    public function getSheets(): array
    {
        $this->setSheets([
            new Sheet([
                'name' => 'sheet1',
                'headerIndex' => 2, // 列头在第二行
                'isSetHeader' => true,
                'columns' => [
                    new Column([
                        'title' => '姓名',
                        'field' => 'name',
                    ]),
                    new Column([
                        'title' => '邮箱',
                        'field' => 'email',
                    ]),
                ],
                'callback' => [$this, 'rowCallback']
            ])
        ]);
        return parent::getSheets();
    }

    /**
     * 行回调处理
     *
     * @param ImportRowCallbackParam $param
     * @return void
     */
    public function rowCallback(ImportRowCallbackParam $param)
    {
        try {
            if (!empty($param->row)) {
                $name = Arr::get($param->row, 'name', '');
                $email = Arr::get($param->row, 'email', '');

                if (empty($name)) {
                    throw new BusinessException(500, '姓名不能为空');
                }

                if (empty($email)) {
                    throw new BusinessException(500, '邮箱不能为空');
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new BusinessException(500, '邮箱格式不正确');
                }

                // 保存导入的数据（实际应该保存到数据库）
                $this->importedData[] = [
                    'name' => $name,
                    'email' => $email,
                    'row_index' => $param->rowIndex + 1,
                ];

                // 这里可以调用服务类保存数据
                // make(SomeService::class)->saveData($param->row);

                // 此处模拟演示输出信息
                $progress = ApplicationContext::getContainer()->get(ProgressInterface::class);
                $progress->pushMessage($param->config->token, sprintf("第%s行,数据:%s", $param->rowIndex + 2, json_encode($param->row, JSON_UNESCAPED_UNICODE)));

            }
        } catch (\Throwable $throwable) {
            throw new BusinessException(500, '第' . ($param->rowIndex + 2) . '行: ' . $throwable->getMessage());
        }
    }

    /**
     * 获取导入的数据（用于测试）
     *
     * @return array
     */
    public function getImportedData(): array
    {
        return $this->importedData;
    }
}

