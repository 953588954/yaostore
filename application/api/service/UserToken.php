<?php
namespace app\api\service;

use think\Exception;
use app\lib\exception\GetOpenidException;
use app\api\model\User;
use think\Log;
class UserToken extends Token{
    protected $code;
    protected $appid;
    protected $secret;
    protected $wxLoginUrl;
    
    public function __construct($code){
        $this->code = $code;
        $this->appid = config('queue.appid');
        $this->secret = config('queue.secret');
        $this->wxLoginUrl = sprintf(config('queue.login_url'),$this->appid,$this->secret,$this->code);
    }
    
    /*
     * 请求微信服务器 获取appid 
     * 存入数据库 
     * 生成令牌
     * 将用户id 令牌 存入缓存
     * @return token
     */
    public function get(){
        $result = curl_get($this->wxLoginUrl);
        $wxRst = json_decode($result,true);
        if (empty($wxRst)){
            throw new Exception("请求微信服务器获取openid失败");
        }else{
            if (array_key_exists('errcode', $wxRst)){
                //抛出异常
                throw new GetOpenidException(['msg'=>'获取微信openid失败：'.$wxRst['errcode']]);
            }else{
                //获取token返回
                $token = $this->grantToken($wxRst);
                return $token;
            }
        }
    }
    
    /*
     * 生成令牌
     */
    private function grantToken($wxRst){
        $openid = $wxRst['openid'];
        //查询数据库，如果存在返回用户id ，如果不存在 存入数据库 返回id
        $userModel = new User();
        $userInfo = $userModel->where('use_openid',$openid)->find();
        if ($userInfo){
            $uid = $userInfo->use_id;
        }else{  //存入数据库
            $userModel->use_openid = $openid;
            $userModel->save();
            $uid = $userModel->use_id;
        }
        //准备缓存数据
        $cacheVal = $this->preparCacheVal($wxRst, $uid);
        //存入缓存 返回token
        $token = $this->saveToCache($cacheVal);
        return $token;
    }
    
    //uid openid session_key unionid 返回一维数组
    private function preparCacheVal($wxRst,$uid){
        $cacheValue = $wxRst;
        $cacheValue['uid'] = $uid;
        return $cacheValue;
    }
    
    //生成令牌  存入缓存
    private function saveToCache($cacheVal){
        $token = $this->generatToken(); //生成令牌
        $value = json_encode($cacheVal);
        $expire = config('queue.token_expire_time');
        
        $result = cache($token,$value,$expire);
        if(!$result){
            throw new GetOpenidException(['msg'=>'服务器缓存异常','errorCode'=>10007]);
        }
        
        return $token;
    }
    
   
    
    
    
    
    
}