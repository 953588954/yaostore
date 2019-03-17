<?php
namespace app\admin\model;

use think\Model;
use app\admin\controller\BaseController;
class Root extends Model{
    protected $autoWriteTimestamp = true;
    
    //存数据库之前吧密码加密
    //修改器
    public function setRootPwdAttr($value){
        $pwd = md5(config('queue.salt').$value);
        return $pwd;
    }
    
   /*
    * 修改密码前  验证手机号 验证两次密码
    */
    public function checkPwd($params){
        if ($params['new_pwd'] != $params['check_pwd']){
            (new BaseController())->toError("两次密码不一样", "Index/index");
        }
        $root_id = session("rootInfo.root_id");
        $info = self::get($root_id);
        $root_phone = $info['root_phone'];
        if ($params['phone'] != $root_phone){
            (new BaseController())->toError("预留手机号不正确", "Index/index");
        }
        $info->root_pwd = $params['new_pwd'];
        $info->save();
    }
    
    
}