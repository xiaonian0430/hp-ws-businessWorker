<?php
/**
 * 启动文件
 * @author: Xiao Nian
 * @contact: xiaonian030@163.com
 * @datetime: 2021-09-14 10:00
 */
use Workerman\Worker;
use GatewayWorker\BusinessWorker;

//初始化
ini_set('display_errors', 'on');
defined('IN_PHAR') or define('IN_PHAR', boolval(\Phar::running(false)));
defined('SERVER_ROOT') or define('SERVER_ROOT', IN_PHAR ? \Phar::running() : realpath(getcwd()));

// 检查扩展或环境
if(strpos(strtolower(PHP_OS), 'win') === 0) {
    exit("start.php not support windows.\n");
}
if(!extension_loaded('pcntl')) {
    exit("Please install pcntl extension.\n");
}
if(!extension_loaded('posix')) {
    exit("Please install posix extension.\n");
}

//自动加载文件
require_once SERVER_ROOT . '/core/autoload.php';

//导入配置文件
$mode='produce';
foreach ($argv as $item){
    $item_val=explode('=', $item);
    if(count($item_val)==2 && $item_val[0]=='-mode'){
        $mode=$item_val[1];
    }
}
if (!file_exists(SERVER_ROOT . '/config/'.$mode.'.php')) {
    $conf = require_once SERVER_ROOT . '/config/'.$mode.'.php';
}else{
    exit('/config/'.$mode.".php not set\n");
}
defined('CONFIG') or define('CONFIG', $conf);

//创建临时目录
$temp_path='./tmp/log';
if(!is_dir($temp_path)){
    mkdir($temp_path, 0777, true);
}

//初始化worker
Worker::$stdoutFile = $temp_path.'/error.log';
Worker::$logFile = $temp_path.'/log.log';

// businessWorker 进程
$business = new BusinessWorker();

// worker名称
$business->name = CONFIG['BUSINESS']['SERVER_NAME'];

// businessWorker进程数量
$business->count = CONFIG['BUSINESS']['PROCESS_COUNT'];

// 服务注册地址
$registerAddress=CONFIG['REGISTER']['LAN_IP'].':'.CONFIG['REGISTER']['LAN_PORT'];
$business->registerAddress = $registerAddress;

$business->eventHandler=CONFIG['BUSINESS']['EVENT_HANDLER'];

// 运行所有服务
Worker::runAll();
