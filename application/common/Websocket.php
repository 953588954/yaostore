<?php
namespace app\common;

use app\admin\model\Chat;

class Websocket
{
    
    public static function init()
    {
        return new self();
    }
    
    /**
     * 小程序客户端连接成功后，计算该用户有多少未读消息
     * @param Swoole\Http\Request $request
     */
    public function countNoreadMsg($ws, $request)
    {
        $fd = $request->fd;
        $getArr = $request->get;
        if (!empty($getArr) && isset($getArr['token']) && !empty($getArr['token'])) {
            if ($getArr['token'] == config('queue.websocket_kefu')) {   //客服连接
                return Predis::getInstance()->set($getArr['token'].$fd, $fd);   //缓存 客服标识 => fd
            } else {    //用户连接
                $cacheRst = cache($getArr['token']);
                if ($cacheRst){
                    if (!is_array($cacheRst)){
                        $cacheRst = json_decode($cacheRst,true);
                    }
                    if (array_key_exists('openid', $cacheRst)){
                        return Predis::getInstance()->set($cacheRst['openid'], $fd);   //缓存openid => fd
                    }
                }
            }
        }
        return $ws->close($fd);
    }
    
    /**
     * 客户端发送数据,并保存
     * @param int $sfd 哪个客户端发送的
     * @param object $data {msg:发送的数据;type:哪方发送的;openid:客户标识} 1客服发送给用户 2用户发送给客服
     */
    public function sendMsgAndSave($ws, $sfd, $data)
    {
        if ($data->type && $data->msg) {
            if ($data->type == 1 && !empty($data->openid)) {
                $fd = Predis::getInstance()->get($data->openid);
                if ($fd) {
                    $ws->push($fd, json_encode(['msg' => $data->msg]));
                }
                $sql = "insert into `chat` (msg,openid,type,isread,creat_time) values ('{$data->msg}', '{$data->openid}', 1,0,'".date('Y-m-d H:i:s')."')";
            }
            if ($data->type == 2) {
                $openid = $this->getKeyByVal($sfd);
                $allKefuKeys = Predis::getInstance()->keys(config('queue.websocket_kefu').'*');
                foreach ($allKefuKeys as $val) {//给所有客服发送
                    $fd = Predis::getInstance()->get($val);
                    $ws->push($fd, json_encode(['msg' => $data->msg, 'openid' => $openid]));
                }
                $sql = "insert into `chat` (msg,openid,type,isread,creat_time) values ('{$data->msg}', '{$openid}', 2,0,'".date('Y-m-d H:i:s')."')";
            }
            //异步将数据插入数据库
            Mysqlasync::getInstance()->query($sql);
        }
    }
    
    //根据fd查找相应的key
    private function getKeyByVal($fd)
    {
        $allKeys = Predis::getInstance()->keys('*');
        foreach ($allKeys as $val) {
            if (Predis::getInstance()->get($val) == $fd) {
                return $val;
            }
        }
    }
    
    /**
     * 当客户端断开连接时，删除相应的redis缓存
     * @param unknown $fd
     */
    public function removeRedisCache($fd)
    {
        $key = $this->getKeyByVal($fd);
        if (!empty($key))
            Predis::getInstance()->del($key);
    }
    
    /**
     * 当服务启动前，清除下redis所有数据
     */
    public function flushCache()
    {
        Predis::getInstance()->flushdb();
    }
}
