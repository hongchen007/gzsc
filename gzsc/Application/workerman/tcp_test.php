<?php

use Workerman\Worker;
require_once __DIR__ . '../Autoloader.php';

// 创建一个Worker监听2347端口，不使用任何应用层协议
$tcp_worker = new Worker("tcp://192.168.31.125:2347");

// 启动4个进程对外提供服务
$tcp_worker->count = 4;

// 当客户端发来数据时
$tcp_worker->onMessage = function($connection, $data)
{
    // 向客户端发送hello $data
    
    $connection->send('test' . $data);

    $data = json_decode($data,true);

    file_put_contents('./Upload/ltjl.txt',"$data");

    print_r($data);
};

// 运行worker
Worker::runAll();