<?php
/**
 * 业务进程
 * @author: Xiao Nian
 * @contact: xiaonian030@163.com
 * @datetime: 2021-09-14 10:00
 */
use \Workerman\Worker;
use \GatewayWorker\BusinessWorker;

$conf = require_once SERVER_ROOT . '/config/'.GLOBAL_MODE.'.php';

// businessWorker 进程
$worker = new BusinessWorker();

// worker名称
$worker->name = 'BusinessWorker';

// businessWorker进程数量
$worker->count = 4;

// 服务注册地址
$registerAddress=$conf['REGISTER']['LISTEN_ADDRESS'].':'.$conf['REGISTER']['PORT'];
$worker->registerAddress = $registerAddress;

// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START')) {
    Worker::runAll();
}

