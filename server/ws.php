<?php

use app\common\Websocket;

class Ws {
    const HOST = "0.0.0.0";
    const PORT = 8080;
    
    public $ws = null;
    
    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT, SWOOLE_BASE, SWOOLE_SOCK_TCP | SWOOLE_SSL);
        
        $this->ws->set([
            'document_root' => __DIR__.'/../public',
            'worker_num' => 2,
            'task_worker_num' => 2,
            'ssl_key_file' => '/usr/local/cert/yaostore.weixinhkj.xyz_ssl.key',
            'ssl_cert_file' => '/usr/local/cert/yaostore.weixinhkj.xyz_ssl.crt'
        ]);
        
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('workerstart', [$this, 'onWorkerstart']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);
        $this->ws->on('close', [$this, 'onClose']);
        
        $this->ws->start();
    }
    
    //客户端连接后，将用户的未读消息总数返回
    public function onOpen($server, $request)
    {
        // var_dump('open',$request);
        Websocket::init()->countNoreadMsg($this->ws, $request);
    }
    
    public function onMessage($server, $fram)
    {
        // var_dump($fram);
        Websocket::init()->sendMsgAndSave($this->ws, $fram->fd, json_decode($fram->data));
    }
    
    public function onWorkerstart($server, $worker_id)
    {
        
        Websocket::init()->flushCache();
    }
    
    
    public function onTask($server, $task_id, $srv_worker_id, $data)
    {
        
    }
    
    public function onFinish($server, $task_id, $data)
    {
        
    }
    
    public function onClose($server, $fd, $reactorId)
    {
        // var_dump('fd',$fd);
        Websocket::init()->removeRedisCache($fd);
    }
}

new Ws();

