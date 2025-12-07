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

Router::addGroup('/excel',function (){
    // 导出
    Router::addRoute(['get','post'],'/export','App\Controller\ExcelController@export');
    // 导入
    Router::post('/import','App\Controller\ExcelController@import');
    // 获取进度
    Router::get('/progress','App\Controller\ExcelController@progress');
    // 获取输出消息
    Router::get('/message','App\Controller\ExcelController@message');
    // 业务信息
    Router::get('/info','App\Controller\ExcelController@info');
});

// Demo 路由
Router::addGroup('/demo', function () {
    Router::get('/index', 'App\Controller\DemoController@index');
    Router::get('/list', 'App\Controller\DemoController@list');
    Router::post('/upload', 'App\Controller\DemoController@upload');
});
