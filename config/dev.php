<?php
/**
 * @author: Xiao Nian
 * @contact: xiaonian030@163.com
 * @datetime: 2019-12-01 14:01
 */

//SWOOLE 1 其他 0
return [
    'EVENT_LOOP'=>1,
    'REGISTER'    => [
        'LAN_IP'         => '172.16.1.174',
        'LAN_PORT'       => 1236
    ],
    'BUSINESS'    => [
        'SERVER_NAME'    => 'BusinessWorker',
        'PROCESS_COUNT'     => 4,  //进程数
        'EVENT_HANDLER'       => 'Events'
    ]
];
