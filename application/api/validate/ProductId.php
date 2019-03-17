<?php
namespace app\api\validate;

class ProductId extends BaseValidate{
    protected $rule = [
        'id' => 'require|checkId' 
    ];
    
    protected $message = [
        'id' => '传入参数id有误'
    ];
}