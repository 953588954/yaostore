<?php
namespace app\api\validate;

class Theme extends BaseValidate{
    protected $rule = [
        'page' => 'require|checkId'
    ];
    
    protected $message = [
        'page' => 'page参数必须是正整数'
    ];
}