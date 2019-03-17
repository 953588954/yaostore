<?php
namespace app\admin\controller;

use think\Controller;
class BaseController extends Controller{
    
    public function __construct(){
        parent::__construct();
        
        $admin_id = session('rootInfo.root_id');
        if (empty($admin_id)){
            $this->redirect('Login/login');exit;
        }
    }
    
    /*
     * 验证器出错跳转方法
     */
    public function toError($msg,$url){
        $this->error($msg,$url);exit;
    }
}