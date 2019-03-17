<?php
namespace app\api\validate;

class Code extends BaseValidate{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];
    
    protected $message = [
        'code' => '缺少code参数'
    ];
}