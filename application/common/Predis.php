<?php
/*
 * phpredis 基类
 */
namespace app\common;

class Predis{
    const HOST = '127.0.0.1';
    const POST = 6379;
    const TIME_OUT = 5;
    
    public $redis = null;
    
    private static $instance = null;
    
    private function __construct(){
        $this->redis = new \Redis();
        $rst = $this->redis->connect(self::HOST, self::POST, self::TIME_OUT);
        $this->redis->select(1);
        if ($rst === false){
            throw new \Exception('redis连接失败');
        }
    }
    
    public static function getInstance(){
        if (empty(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function set($key, $val, $time = 0){
        if (!$key){
            return '';
        }
        if (is_array($val)){
            $val = json_encode($val);
        }
        if (!$time){
            return $this->redis->set($key, $val);
        }
        return $this->redis->setex($key, $time, $val);
    }
    
    public function get($key){
        if (!$key){
            return '';
        }
        return $this->redis->get($key);
    }
    
    /**
     * 加入集合
     */
    public function sadd($key, $val)
    {
        return $this->redis->sAdd($key, $val);
    }
    
    /**
     * 删除集合中某一个元素
     */
    public function srem($key, $val)
    {
        return $this->redis->srem($key, $val);
    }
    
    /**
     * 获取某一个集合中所有元素
     */
    public function smembers($key)
    {
        return $this->redis->sMembers($key);
    }
    
    /**
     * 魔术方法 当调用不存在的方法时
     * @param name 调用不存在的方法名
     * @param arguments 数组，方法传递的参数
     */
    public function __call($name, $arguments)
    {
        if (count($arguments) == 0) {
            return $this->redis->$name();
        } else if (count($arguments) == 1) {
            return $this->redis->$name($arguments[0]);
        } else if (count($arguments) == 2) {
            return $this->redis->$name($arguments[0], $arguments[1]);
        }
    }
    
}