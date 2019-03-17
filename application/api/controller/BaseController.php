<?php
namespace app\api\controller;

use think\Controller;
use app\api\service\Token;
class BaseController extends Controller{
    /*
     * 用户操作 小程序api前置方法
     */
    public function checkAuth(){
        $tokenService = new Token();
        $tokenService->checkScope();
    }
}