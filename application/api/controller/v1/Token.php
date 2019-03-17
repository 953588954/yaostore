<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\Code;
use app\api\service\UserToken;
use app\lib\exception\ParamertersException;
use app\api\service\Token as TokenService;
class Token extends BaseController{
    
    /*
     * 根据code参数生成令牌返回
     * @url POST
     * @param string code
     * @return json token
     */
    public function getToken(){
        (new Code())->goCheck();
        
        $code = input('post.code');
        $userTokenService = new UserToken($code);
        $token = $userTokenService->get(); 
        return json(['token'=>$token]);
    }
    
    
    /*
     * 小程序刚启动时 检测一次
     * 检验令牌是否过期
     * @return json isValid = true|false
     */
    public function verifyToken(){
        $token = input('post.token');
        if (!$token){
            throw new ParamertersException(['msg'=>'令牌不允许为空','errorCode'=>10008]);
        }
        $isValid = TokenService::verifyToken($token);
        return json(['isValid'=>$isValid]);
    }
    
    
    
    
}