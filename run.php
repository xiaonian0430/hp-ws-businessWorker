<?php
/**
 * 启动文件
 * @author: Xiao Nian
 * @contact: xiaonian030@163.com
 * @datetime: 2021-09-14 10:00
 */

use HP\BusinessWorker\App;

//初始化
ini_set('display_errors', 'on');
defined('IN_PHAR') or define('IN_PHAR', boolval(\Phar::running(false)));
defined('SERVER_ROOT') or define('SERVER_ROOT', IN_PHAR ? \Phar::running() : realpath(getcwd()));

//自动加载文件
$auto_file=SERVER_ROOT . '/vendor/autoload.php';
if (file_exists($auto_file)) {
    require_once $auto_file;
} else {
    exit("Please composer install.\n");
}

//业务事件入口
$event_file=SERVER_ROOT.'/Events.php';
if (file_exists($event_file)) {
    require_once $event_file;
} else {
    exit("Events.php not exist.\n");
}

//初始化应用
$app = new App();

//启动
$app->run();