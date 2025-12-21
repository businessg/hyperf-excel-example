<?php

declare(strict_types=1);

namespace App\Excel\Export;

use App\Excel\Export\Base\AbstractExportConfig;
use Vartruexuan\HyperfExcel\Data\Export\Column;
use Vartruexuan\HyperfExcel\Data\Export\ExportCallbackParam;
use Vartruexuan\HyperfExcel\Data\Export\Sheet;
use Vartruexuan\HyperfExcel\Data\Export\Style;
use Vartruexuan\HyperfExcel\Data\Export\Type\DateType;
use Vartruexuan\HyperfExcel\Data\Export\Type\FormulaType;
use Vartruexuan\HyperfExcel\Data\Export\Type\ImageType;
use Vartruexuan\HyperfExcel\Data\Export\Type\TextType;
use Vartruexuan\HyperfExcel\Data\Export\Type\UrlType;

/**
 * SpreadSheet驱动导出 Demo（包含所有数据类型）
 * 演示如何使用 PhpSpreadsheet 驱动并配置所有数据类型：
 * 1. TextType - 文本类型（支持格式化）
 * 2. DateType - 日期类型
 * 3. UrlType - URL链接类型
 * 4. FormulaType - 公式类型
 * 5. ImageType - 图片类型
 */
class DemoSpreadSheetDriverExportConfig extends AbstractExportConfig
{
    public string $serviceName = 'Demo SpreadSheet驱动导出';

    public string $outPutType = self::OUT_PUT_TYPE_UPLOAD;

    public bool $isAsync = true;

    /**
     * 指定使用的驱动名称
     * 
     * @var string
     */
    public string $driverName = 'spreadsheet';

    public function getSheets(): array
    {
        $this->setSheets([
            new Sheet([
                'name' => '数据类型示例',
                'columns' => [
                    // ========== 1. TextType - 文本类型 ==========
                    // 文本类型（默认，无格式）
                    new Column([
                        'title' => 'ID',
                        'field' => 'id',
                        'type' => new TextType(), // 或使用字符串 'text'
                        'width' => 10,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),
                    // 文本类型（字符串方式）
                    new Column([
                        'title' => '姓名',
                        'field' => 'name',
                        'type' => 'text', // 字符串方式
                        'width' => 15,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),
                    // 文本类型（数字格式：千分位，保留两位小数）
                    new Column([
                        'title' => '余额',
                        'field' => 'balance',
                        'type' => new TextType([
                            'format' => '#,##0.00', // 数字格式：千分位，保留两位小数
                        ]),
                        'width' => 15,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),
                    // 文本类型（百分比格式）
                    new Column([
                        'title' => '完成度',
                        'field' => 'progress',
                        'type' => new TextType([
                            'format' => '0.00%', // 百分比格式
                        ]),
                        'width' => 12,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),
                    // 文本类型（货币格式）
                    new Column([
                        'title' => '金额',
                        'field' => 'amount',
                        'type' => new TextType([
                            'format' => '¥#,##0.00', // 货币格式
                        ]),
                        'width' => 15,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),

                    // ========== 2. DateType - 日期类型 ==========
                    // 日期类型（日期时间格式）
                    new Column([
                        'title' => '创建时间',
                        'field' => 'created_at',
                        'type' => new DateType([
                            'dateFormat' => 'yyyy-mm-dd hh:mm:ss', // Excel日期格式
                        ]),
                        'width' => 20,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),
                    // 日期类型（仅日期）
                    new Column([
                        'title' => '注册日期',
                        'field' => 'register_date',
                        'type' => new DateType([
                            'dateFormat' => 'yyyy-mm-dd',
                        ]),
                        'width' => 15,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),
                    // 日期类型（时间格式）
                    new Column([
                        'title' => '最后登录时间',
                        'field' => 'last_login_time',
                        'type' => new DateType([
                            'dateFormat' => 'hh:mm:ss',
                        ]),
                        'width' => 15,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),

                    // ========== 3. UrlType - URL链接类型 ==========
                    // URL类型（默认，显示URL本身）
                    new Column([
                        'title' => '个人主页',
                        'field' => 'website',
                        'type' => new UrlType(), // URL类型，会显示为可点击链接
                        'width' => 30,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),
                    // URL类型（自定义显示文本）
                    new Column([
                        'title' => 'GitHub',
                        'field' => 'github_url',
                        'type' => new UrlType([
                            'text' => '查看代码', // 自定义链接显示文本
                            'tooltip' => '点击访问GitHub仓库', // 鼠标悬停提示
                        ]),
                        'width' => 15,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),

                    // ========== 4. FormulaType - 公式类型 ==========
                    // 公式类型（求和公式 - 引用当前行的其他列）
                    // 注意：公式中的行号需要根据实际位置动态计算
                    // 这里演示公式类型的使用，实际使用时需要根据列位置调整公式
                    new Column([
                        'title' => '合计',
                        'field' => 'total',
                        'type' => new FormulaType(),
                        'width' => 15,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                        'callback' => function ($row) {
                            // 返回Excel公式字符串（不包含等号，驱动会自动添加）
                            // 公式引用当前行的余额列(E)和金额列(F)
                            // 注意：实际使用时，行号会在驱动中根据实际位置填充
                            // 这里使用占位符演示，实际驱动会处理行号
                            // 公式格式：SUM(E2:F2) 表示对E2到F2单元格求和
                            return 'SUM(E2:F2)'; // 示例公式，实际行号由驱动填充
                        },
                    ]),
                    // 公式类型（计算平均值）
                    new Column([
                        'title' => '平均值',
                        'field' => 'average',
                        'type' => new FormulaType(),
                        'width' => 15,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                        'callback' => function ($row) {
                            // 返回平均值公式
                            // 公式格式：AVERAGE(E2:F2) 表示计算E2到F2的平均值
                            return 'AVERAGE(E2:F2)'; // 示例公式
                        },
                    ]),

                    // ========== 5. ImageType - 图片类型 ==========

                    new Column([
                        'title' => '头像',
                        'field' => 'avatar',
                        'type' => new ImageType([
                            'width' => 50,
                            'height' => 50,
                        ]),
                        'width' => 12,
                        'height' => 60,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),
                    new Column([
                        'title' => '二维码',
                        'field' => 'qrcode',
                        'type' => new ImageType([
                            'widthScale' => 0.5,
                            'heightScale' => 0.5,
                        ]),
                        'width' => 15,
                        'height' => 60,
                        'headerStyle' => new Style([
                            'bold' => true,
                            'align' => [Style::FORMAT_ALIGN_CENTER],
                            'fontSize' => 11,
                            'backgroundColor' => 0xD9E1F2,
                            'backgroundStyle' => Style::PATTERN_SOLID,
                            'fontColor' => 0x1F4E78,
                        ]),
                    ]),
                ],
                'count' => $this->getDataCount(),
                'data' => [$this, 'getData'],
                'pageSize' => 100,
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
        return 100; // 减少数据量，便于查看所有类型
    }

    /**
     * 获取数据
     *
     * @param ExportCallbackParam $exportCallbackParam
     * @return array
     */
    public function getData(ExportCallbackParam $exportCallbackParam): array
    {
        $page = $exportCallbackParam->page;
        $pageSize = $exportCallbackParam->pageSize;

        // 生成模拟数据，展示所有数据类型
        $data = [];
        $totalCount = $this->getDataCount();

        for ($i = 0; $i < $pageSize; $i++) {
            $index = ($page - 1) * $pageSize + $i + 1;
            if ($index > $totalCount) {
                break;
            }

            $data[] = [
                // TextType 数据
                'id' => $index,
                'name' => '用户' . $index,
                'balance' => rand(1000, 999999) / 100, // 金额（带小数）
                'progress' => rand(0, 100) / 100, // 进度（0-1之间的小数，用于百分比）
                'amount' => rand(500, 50000) / 100, // 金额（用于货币格式）

                // DateType 数据
                'created_at' => date('Y-m-d H:i:s', time() - rand(0, 86400 * 30)), // 日期时间
                'register_date' => date('Y-m-d', time() - rand(0, 86400 * 365)), // 仅日期
                'last_login_time' => date('H:i:s', time() - rand(0, 86400)), // 时间

                // UrlType 数据
                'website' => 'https://example.com/user/' . $index, // URL类型
                'github_url' => 'https://github.com/user' . $index, // GitHub链接

                // FormulaType 数据
                // 注意：公式类型的数据在callback中生成，这里不需要提供实际值
                'total' => '', // 公式列，值由callback生成
                'average' => '', // 公式列，值由callback生成

                // ImageType 数据（已暂时移除，避免远程图片下载导致的段错误）
                'avatar' => sprintf('https://api.dicebear.com/7.x/avataaars/png?seed=user%d&size=50', $index),
                'qrcode' => sprintf('https://api.qrserver.com/v1/create-qr-code/?size=100x100&format=png&data=user%d', $index),
            ];
        }

        return $data;
    }
}

