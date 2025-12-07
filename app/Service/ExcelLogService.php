<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use Hyperf\Collection\Arr;
use Hyperf\Di\Annotation\Inject;
use Vartruexuan\HyperfExcel\ExcelInterface;
use Vartruexuan\HyperfExcel\Progress\ProgressData;
use Vartruexuan\HyperfExcel\Progress\ProgressRecord;
use function Hyperf\Config\config;

class ExcelLogService extends AbstractService
{
    #[Inject]
    private ExcelInterface $excel;
    /**
     * 获取进度
     *
     * @param string $token
     * @return ProgressRecord|null
     */
    public function getProgressByToken(string $token): ?ProgressRecord
    {
        return $this->excel->getProgressRecord($token);
    }

    /**
     * 获取数组
     *
     * @param string $token
     * @return array|null
     */
    public function getProgressArrayByToken(string $token): ?array
    {
        $record = $this->getProgressByToken($token)?->toArray();
        if (!$record) {
            throw new BusinessException(500, '对应记录不存在');
        }
        return $record;
    }

    /**
     * 获取进度消息
     *
     * @param string $token
     * @param int $num
     * @return array
     */
    public function getMessageByToken(string $token, int $num = 50): array
    {
        $record = $this->getProgressByToken($token);
        $message = $this->excel->popMessage($token, $num);

        if (!$record) {
            throw new BusinessException(500, '对应记录不存在');
        }
        return [
            'isEnd' => empty($message) && in_array($record?->progress?->status, [ProgressData::PROGRESS_STATUS_COMPLETE, ProgressData::PROGRESS_STATUS_FAIL]),
            'message' => $message
        ];
    }

    /**
     * 获取业务信息
     *
     * @param string $businessId
     * @return array
     */
    public function getInfoByBusinessId(string $businessId)
    {
        $config = $this->getImportConfigByBusinessId($businessId);
        return Arr::get($config ?? [], 'info', []);
    }

    /**
     * 导出
     *
     * @param string $businessId
     * @param array $param
     * @return array
     * @throws \Throwable
     */
    public function exportByBusinessId(string $businessId, array $param = []): array
    {
        $config = $this->getExportConfigByBusinessId($businessId);
        if (!$config) {
            throw new BusinessException(500, '对应业务ID不存在');
        }
        $config = new $config['config']([
            'params' => $param,
        ]);
        $data = $this->excel->export($config);

        return [
            'token' => $data->token,
            'response' => $data->getResponse(), // 同步上传时可直接获取到地址
        ];
    }

    /**
     * 导入
     *
     * @param string $businessId
     * @param string $url
     * @return array
     * @throws \Throwable
     */
    public function importByBusinessId(string $businessId, string $url)
    {
        $config = $this->getImportConfigByBusinessId($businessId);
        if (!$config) {
            throw new BusinessException(500, '对应业务ID不存在');
        }
        $importConfig = new $config['config'](['path' => $url]);
        $data = $this->excel->import($importConfig);
        return [
            'token' => $data->token,
        ];
    }

    /**
     * 获取导出配置
     *
     * @param string $businessId
     * @return mixed
     */
    public function getExportConfigByBusinessId(string $businessId)
    {
        return config('excel_business.export.' . $businessId);
    }

    /**
     * 获取导入配置
     *
     * @param string $businessId
     * @return mixed
     */
    public function getImportConfigByBusinessId(string $businessId)
    {
        return config('excel_business.import.' . $businessId);
    }

}

