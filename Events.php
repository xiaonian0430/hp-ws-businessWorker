<?php
/**
 * 业务逻辑
 * @author: Xiao Nian
 * @contact: xiaonian030@163.com
 * @datetime: 2021-09-14 10:00
 */
use App\Service\Events as ServiceEvents;
class Events {

    /**
     * @param $client_id
     * @param $message
     * @throws Exception
     */
    public static function onMessage($client_id, $message){
        ServiceEvents::getInstance()->onMessage($client_id, $message);
    }
   
    /**
     * 当客户端断开连接时
     * @param $client_id
     */
    public static function onClose($client_id){
        ServiceEvents::getInstance()->onClose($client_id);
    }
}
