<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\lib\exception\ParamertersException;
use app\api\model\User as UserModel;
use app\api\service\Token;
use think\Log;
class User extends BaseController{
    
    /**
     * 保存用户 头像 微信 名称
     * POST
     * @param array userInfo ['nickName','gender','avatarUrl','country','province','city']
     */
    public function saveUserInfo(){
        $uid = Token::getTokenValue();  //获取此用户id
        $userInfo = input('post.userInfo/a');
        
        if (!isset($userInfo['nickName']) || !isset($userInfo['gender']) || !isset($userInfo['avatarUrl']) || !isset($userInfo['country']) || !isset($userInfo['province']) || !isset($userInfo['city'])){
            throw new ParamertersException(['msg'=>'保存微信用户信息参数错误']);
        }
        //微信0代表性别未知  做一下转换
        $gender = $userInfo['gender']==0?'3':$userInfo['gender'];
        
        $userModel = new UserModel();
        $array = [
            'use_nickname' => $userInfo['nickName'],
            'use_sex' => $gender,
            'use_head_img' => $userInfo['avatarUrl'],
            'use_country' => $userInfo['country'],
            'use_province' => $userInfo['province'],
            'use_city' => $userInfo['city']
        ];
        $userModel->save($array,['use_id'=>$uid]);
        
        return json([
            'error' => 0,
            'msg' => '保存用户微信信息成功'
        ]);
        
    }
    
    //测试
    public function test()
    {
        $params = input('get.param');
        // Log::init([
        //     'type' => 'File',
        //     'path' => LOG_PATH,
        //     'level' => ['error']
        // ]);
        // Log::record('ceshi:'.$params);
            $filename = "./error.txt";
            $fp = fopen($filename, 'a+');
            fwrite($fp, date("Y-m-d H:i:s",time()).":测试模板消息参数："."\r\n");
            fwrite($fp, $params."\r\n");
            fclose($fp);
    }
    
}