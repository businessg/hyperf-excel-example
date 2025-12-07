<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use Carbon\Carbon;
use Hyperf\Collection\Arr;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Upload\UploadedFile;
use League\Flysystem\Filesystem;
use function Hyperf\Config\config;
use function Hyperf\Collection\last;

class FileService extends AbstractService
{
    #[Inject]
    public Filesystem $filesystem;

    public string $storage = '';

    /**
     * 文件上传
     *
     * @param UploadedFile $file
     * @return array
     * @throws \Random\RandomException
     */
    public function upload(UploadedFile $file): array
    {
        $relativePath = $this->getRelativePath($file->getClientFilename());
        $this->filesystem->writeStream($relativePath, fopen($file->getRealPath(), 'r+'));
        if (!$this->filesystem->fileExists($relativePath)) {
            throw new BusinessException(500, '上传文件失败');
        }

        return [
            'filePath' => $relativePath,
        ];
    }

    /**
     * 获取文件相对路径（相对于存储根目录），用于 Filesystem 保存
     *
     * @param string $fileName
     * @return string
     * @throws \Random\RandomException
     */
    protected function getRelativePath(string $fileName): string
    {
        // 返回相对路径，格式：年/月/日/文件名
        return $this->buildFileDir() . '/' . $this->buildFileName($fileName);
    }

    /**
     * 构建文件目录
     *
     * @return string
     */
    public function buildFileDir(): string
    {
        return date('Y') . '/' . date('m') . '/' . date('d');
    }

    /**
     * 获取新文件名
     *
     * @param string $fileName
     * @return string
     * @throws \Random\RandomException
     */
    public function buildFileName(string $fileName): string
    {
        $newFileName = md5($fileName . Carbon::now()->timestamp . random_int(1000, 10000));
        $fileNames = explode('.', $fileName);
        $ext = last($fileNames);
        return $newFileName . '.' . $ext;
    }

    /**
     * 获取配置
     *
     * @return array
     */
    protected function getConfig(): array
    {
        return config('file', []);
    }

    /**
     * 获取存储配置
     *
     * @return array
     */
    protected function getStorage(): array
    {
        $config = $this->getConfig();
        $storageName = $this->storage ?: ($config['default'] ?? 'local');
        return Arr::get($config, 'storage.' . $storageName, []);
    }
}

