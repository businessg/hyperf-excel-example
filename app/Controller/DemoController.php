<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\FileService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;

#[Controller(prefix: '/demo')]
class DemoController extends AbstractController
{
    #[Inject]
    public FileService $fileService;

    /**
     * Demo 首页视图
     *
     * @return \Swow\Psr7\Message\ResponsePlusInterface
     */
    #[GetMapping(path: '/index')]
    public function index()
    {
        // 模拟数据列表
        $dataList = [];
        for ($i = 1; $i <= 10; $i++) {
            $dataList[] = [
                'id' => $i,
                'name' => '用户' . $i,
                'email' => 'user' . $i . '@example.com',
                'created_at' => date('Y-m-d H:i:s', time() - rand(0, 86400 * 30)),
            ];
        }

        // 渲染视图
        return $this->renderView('demo/index', [
            'dataList' => $dataList,
        ]);
    }

    /**
     * Demo 数据列表 API（用于 AJAX 刷新）
     *
     * @return \Swow\Psr7\Message\ResponsePlusInterface
     */
    #[GetMapping(path: '/list')]
    public function list()
    {
        // 模拟数据列表
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'id' => $i,
                'name' => '用户' . $i,
                'email' => 'user' . $i . '@example.com',
                'created_at' => date('Y-m-d H:i:s', time() - rand(0, 86400 * 30)),
            ];
        }

        return $this->response->success([
            'list' => $data,
            'total' => 100,
        ]);
    }

    /**
     * 渲染视图
     *
     * @param string $view
     * @param array $data
     * @return \Swow\Psr7\Message\ResponsePlusInterface
     */
    protected function renderView(string $view, array $data = []): \Swow\Psr7\Message\ResponsePlusInterface
    {
        $viewPath = BASE_PATH . '/app/View/' . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewPath)) {
            return $this->response->fail('视图文件不存在: ' . $view, 404);
        }

        // 提取数据到变量
        extract($data);

        // 开启输出缓冲
        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        return $this->response->html($content);
    }

    /**
     * 文件上传接口
     *
     * @return \Swow\Psr7\Message\ResponsePlusInterface
     * @throws \Random\RandomException
     */
    #[PostMapping(path: '/upload')]
    public function upload()
    {
        $file = $this->request->file('file');
        
        if (!$file || !$file->isValid()) {
            return $this->response->fail('请选择有效的文件', 400);
        }

        // 验证文件类型（只允许 Excel 文件）
        $allowedExtensions = ['xlsx', 'xls'];
        $extension = strtolower($file->getExtension());
        
        if (!in_array($extension, $allowedExtensions)) {
            return $this->response->fail('只支持上传 Excel 文件（.xlsx, .xls）', 400);
        }

        try {
            $result = $this->fileService->upload($file);
            // 只返回文件路径，不拼接地址
            return $this->response->success([
                'filePath' => $result['filePath'],
            ]);
        } catch (\Exception $e) {
            return $this->response->fail('文件上传失败: ' . $e->getMessage(), 500);
        }
    }
}

