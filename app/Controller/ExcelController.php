<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\Request\ExcelRequest;
use App\Service\ExcelLogService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Psr\Http\Message\ResponseInterface;

#[Controller]
class ExcelController extends AbstractController
{
    #[Inject]
    public ExcelLogService $excelLogService;

    /**
     * 导出
     *
     * @param ExcelRequest $request
     * @return ResponseInterface|\Swow\Psr7\Message\ResponsePlusInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Vartruexuan\HyperfExcel\Exception\ExcelException
     */
    public function export(ExcelRequest $request)
    {
        $request->scene('export')->validateResolved();
        $result = $this->excelLogService->exportByBusinessId($request->input('businessId'), $request->input('param', []));
        // 直接输出
        if ($result['response'] instanceof ResponseInterface) {
            return $result['response'];
        }
        return $this->response->success($result);
    }

    /**
     * 导入
     *
     * @param ExcelRequest $request
     * @return \Swow\Psr7\Message\ResponsePlusInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Vartruexuan\HyperfExcel\Exception\ExcelException
     */
    public function import(ExcelRequest $request)
    {
        $request->scene('import')->validateResolved();
        return $this->response->success($this->excelLogService->importByBusinessId($request->input('businessId'), $request->input('url')));
    }

    /**
     * 进度查询
     *
     * @param ExcelRequest $request
     * @return \Swow\Psr7\Message\ResponsePlusInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function progress(ExcelRequest $request)
    {
        $request->scene('progress')->validateResolved();
        return $this->response->success($this->excelLogService->getProgressArrayByToken($request->input('token')));
    }

    /**
     * 消息查询
     *
     * @param ExcelRequest $request
     * @return \Swow\Psr7\Message\ResponsePlusInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function message(ExcelRequest $request)
    {
        $request->scene('message')->validateResolved();
        return $this->response->success($this->excelLogService->getMessageByToken($request->input('token')));
    }

    /**
     * 业务信息
     *
     * @param ExcelRequest $request
     * @return \Swow\Psr7\Message\ResponsePlusInterface
     */
    public function info(ExcelRequest $request)
    {
        $request->scene('info')->validateResolved();
        return $this->response->success($this->excelLogService->getInfoByBusinessId($request->input('businessId')));
    }
}