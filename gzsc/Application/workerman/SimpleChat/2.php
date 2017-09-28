<?php
use Workerman\Worker;
require_once '../Autoloader.php';
require_once '../mysql/src/Connection.php';

   global $db;
   $db= new Workerman\mysql\Connection('localhost', '3306', 'root', 'root','dsc');
   //执行SQL   执行测试OK
   // $all_tables=$db->select('user_name')->from('user')->query();
   // print_r($all_tables);

// $global_uid = 0;

// 当客户端连上来时分配uid，并保存连接，并通知所有客户端
function handle_connection($connection)
{
    global $text_worker, $global_uid;
    // 为这个链接分配一个socket_uid
    // $connection->uid = ++$global_uid;
    $connection->uid = rand(111111,999999).time();

    //UID said: {type:1,nameuser:2,}
}

// 当客户端发送消息过来时，转发给所有人
function handle_message($connection, $data)
{
    global $text_worker;
    foreach($text_worker->connections as $conn)
    {
        $conn->send("user[{$connection->uid}] said: $data");
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
$text_worker = new Worker("text://192.168.31.125:8080");

// 只启动1个进程，这样方便客户端之间传输数据
$text_worker->count = 1;

$text_worker->onConnect = 'handle_connection';
$text_worker->onMessage = 'handle_message';
$text_worker->onClose = 'handle_close';

Worker::runAll();
///d