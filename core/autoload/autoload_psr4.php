<?php
/**
 * @author: Xiao Nian
 * @contact: xiaonian030@163.com
 * @datetime: 2021-09-14 10:00
 */
$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'App\\' => array($baseDir . '/app'),
    'Workerman\\' => array($baseDir . '/core/framework/workerman'),
    'GatewayWorker\\' => array($baseDir . '/core/framework/gatewayworker'),
);
