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
$auto_file=SERVER_ROOT . '/vendor/autoload.php';
if (file_exists($auto_file)) {
    require_once $auto_file;
} else {
    exit("Please composer install.\n");
}
if (file_exists(SERVER_ROOT.'/Events.php')) {
    require_once SERVER_ROOT.'/Events.php';
} else {
    exit("Events.php not exist.\n");
}

//导入配置文件
$mode='produce';
foreach ($argv as $item){
    $item_val=explode('=', $item);
    if(count($item_val)==2 && $item_val[0]=='-mode'){
        $mode=$item_val[1];
    }
}
$config_path=SERVER_ROOT . '/config/'.$mode.'.php';
if (file_exists($config_path)) {
    $conf = require_once $config_path;
}else{
    exit($config_path." is not exist\n");
}
defined('CONFIG') or define('CONFIG', $conf);

//创建临时目录
$temp_path='./temp/log';
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
