<?php
namespace app\admin\validate;

use think\Validate;
use think\Request;
use app\admin\controller\BaseController;

class BaseValidate extends Validate{
    protected $url;
    //构造方法，赋值出错跳转的url
    public function __construct($url){
        $this->url = $url;
    }
    /*
     * 公共验证方法
     * 
     */
    public function goCheck(){
        $request = Request::instance();
        $params = $request->param();    //获取所有参数
        if (!$this->check($params)){
            (new BaseController())->toError($this->getError(), $this->url);
        }
        return true;
    }
    
    /*
     * 检测值不为空
     */
    public function isNotEmpty($value){
        if (empty(trim($value))){
            return false;
        }
        return true;
    }
    /*
     * 检测id必须是正整数
     */
    public function checkID($value){
        if (is_numeric($value) && ($value+0)>0 && is_int($value+0)){
            return true;
        }
        return false;
    }
    
    /*
     * 检测 价格 必须大于0
     */
    public function checkPrice($value){
        if (is_numeric($value) && ($value+0)>0){
            return true;
        }
        return false;
    }
    
    
    
}