<?php
namespace app\api\validate;

use app\lib\exception\ParamertersException;
use think;
class PlaceOrder extends BaseValidate{
    protected $rule = [
        'oProducts' => 'require|checkOProduct',
        'addressId' => 'require|checkId'
    ];
    
    protected $sigleRule = [
        'id' => 'require|checkId',
        'count' => 'require|checkId'
    ];
    
    
    protected function checkOProduct($values){
        if (empty($values)){
            throw new ParamertersException(['msg'=>'下单参数不能为空']);
        }
        if (!is_array($values)){
           // throw new ParamertersException(['msg'=>'下单参数必须为数组']);
           //var_dump($values);die;
           $values = json_decode($values,true);
        }
        foreach ($values as $v){
            $this->checkSigle($v);
        }
        return true;
    }
    
    protected function checkSigle($values){
        $valdate = new BaseValidate($this->sigleRule);
        $rst = $valdate->check($values);
        if (!$rst){
           throw new ParamertersException(['msg'=>'下单参数错误']);
        }
    }
}