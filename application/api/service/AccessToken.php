<?php
namespace app\api\service;

class AccessToken{
    const EXPIRETIME=7000;  //access_token 过期时间
    const NAME='accesstoken';
    
  
    public static function getAccessToken(){
        $accessToken = cache(self::NAME);
        if (empty($accessToken)){
            $url = sprintf(config('queue.access_token_url'),config('queue.appid'),config('queue.secret'));
            $rst = json_decode(curl_get($url),true);
            if (array_key_exists('errcode', $rst)){ //获取access_token错误
                $filename = "./error.txt";
                $fp = fopen($filename, 'a+');
                fwrite($fp, date("Y-m-d H:i:s",time())."获取access_token出错，错误码：".$rst['errcode']."错误原因:".$rst['errmsg']."\r\n");
                fclose($fp);
            }else{
                $accessToken = $rst['access_token'];
                cache(self::NAME,$accessToken,self::EXPIRETIME);    //缓存
                
            }
        }
        return $accessToken;
        
    }
}