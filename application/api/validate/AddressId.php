<?php
namespace app\api\validate;

class AddressId extends BaseValidate{
    protected $rule = [
        'id' => 'require|checkId'
    ];
    
    protected $message = [
        'id' => '地址参数必须是正整数'
    ];
}