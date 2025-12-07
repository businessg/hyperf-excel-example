<?php

declare(strict_types=1);

namespace App\Kernel\Http;

use Hyperf\Context\ResponseContext;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;
use Swow\Psr7\Message\ResponsePlusInterface;

class Response
{
    public const OK = 0;

    protected ResponseInterface $response;

    public function __construct(protected ContainerInterface $container)
    {
        $this->response = $container->get(ResponseInterface::class);
    }

    public function success(array $data = [], string $message = 'success'): ResponsePlusInterface
    {
        return $this->response->json([
            'code' => 0,
            'msg' => $message,
            'data' => $data,
        ]);
    }

    public function fail(string $message = '', int $code = 1, array $data = []): ResponsePlusInterface
    {
        return $this->response->json([
            'code' => $code,
            'msg' => $message,
            'data' => $data,
        ]);
    }

    public function html(string $content): ResponsePlusInterface
    {
        $response = ResponseContext::get()
            ->withHeader('Content-Type', 'text/html; charset=utf-8');
        $response->getBody()->write($content);
        return $response;
    }
}

