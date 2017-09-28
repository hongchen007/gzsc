<?php
use Workerman\Worker;
require_once '../Autoloader.php';

// $global_uid = 0;

// 当客户端连上来时分配uid，并保存连接，并通知所有客户端
function handle_connection($connection)
{
    global $text_worker, $global_uid;
    // 为这个链接分配一个uid /////---UID的长度为16个
    $connection->uid = rand(111111,999999).time();
    // $connection->uid = ++$global_uid;
    $connection->uid = $global_uid;

    // global $text_worker, $global_uid;
    // // 为这个链接分配一个uid
    // $connection->uid = ++$global_uid;
}

// 当客户端发送消息过来时，转发给所有人
function handle_message($connection, $data)
{
    global $text_worker;

	// ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
	// set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
	// $interval=1;// 每隔1s运行
	// do{
	//     foreach($text_worker->connections as $conn){

	//     }
	//     sleep($interval);// 等待1s    
	// }while(true);

    foreach($text_worker->connections as $conn)
    //每1秒遍历所有在线的人数
    //每1秒向所有用户发送心跳包
    {
        $conn->send("user[{$connection->uid}] said: $data");

        $data = json_decode($data,true);

        print_r($data);

    }
}

// 当客户端断开时，广播给所有客户端
function handle_close($connection)
{
    global $text_worker;
    foreach($text_worker->connections as $conn)
    {
        $conn->send("user[{$connection->uid}] logout");
    }
}

// 创建一个文本协议的Worker监听2347接口
$text_worker = new Worker("text://192.168.31.125:2347");

// 只启动1个进程，这样方便客户端之间传输数据
$text_worker->count = 2000;

$text_worker->onConnect = 'handle_connection';
$text_worker->onMessage = 'handle_message';
$text_worker->onClose = 'handle_close';

Worker::runAll();