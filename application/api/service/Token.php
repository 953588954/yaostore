<?php
namespace app\api\service;

use think\Request;
use app\lib\exception\TokenException;
use think\Exception;
class Token{
    
    /*
     * 生成令牌
     */
    public function generatToken(){
        $randChars = getRandChars();    //随机字符串
        $timestamp = time();
        $salt = config('queue.salt');   //盐
        
        return md5($randChars.$timestamp.$salt);
    }
    
    /*
     * 检验令牌是否过期 或者是否合法
     */
    public static function verifyToken($token){
        $rst = cache($token);
        if($rst){
            return true;
        }else{
            return false;
        }
    }
    
    /*
     * 公共前置方法  
     * 检测 token是否过期 
     */
    public function checkScope(){
        $rst = self::getTokenValue();
        if ($rst){
            return true;
        }else{
            throw new TokenException();
        }
    }
    
    /*
     * 公共方法，根据令牌 获取缓存指定值
     */
    public static function getTokenValue($val='uid'){
        $token = Request::instance()->header('token');
        $cacheRst = cache($token);
        if (!$cacheRst){
            throw new TokenException();
        }else{
            if (!is_array($cacheRst)){
                $cacheRst = json_decode($cacheRst,true);
            }
            if (array_key_exists($val, $cacheRst)){
                return $cacheRst[$val];
            }else {
                throw new Exception('尝试获取缓存的key不存在');
            }
        }
    }
    
    
    
}