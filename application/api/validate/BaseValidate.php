<?php
namespace app\api\validate;

use think\Validate;
use app\lib\exception\ParamertersException;
class BaseValidate extends Validate{
    /*
     * 公共验证方法
     */
    public function goCheck(){
        $params = input('param.');
        if (!$this->batch()->check($params)){
            $errMsg = $this->getError();
            if (is_array($errMsg)){
                $errMsg = implode(',', $errMsg);
            }
            throw new ParamertersException([
                'msg' => $errMsg
            ]);
        }
        return true;
    }
    
    /*
     * 验证必须是正整数
     */
    public function checkId($id){
        if (is_numeric($id) && ($id+0)>0 && is_int($id+0)){
            return true;
        }else {
           return false;
        }
    }
    
    /*
     * 验证不能为空
     */
    public function isNotEmpty($value){
        if (empty($value)){
            return false;
        }else {
            return true;
        }
    }
    
    
    
}