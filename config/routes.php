<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});

// Demo 路由
Router::addGroup('/demo', function () {
    Router::get('/index', 'App\Controller\DemoController@index');
    Router::get('/list', 'App\Controller\DemoController@list');
    Router::post('/upload', 'App\Controller\DemoController@upload');
});
