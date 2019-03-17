<?php
namespace app\admin\validate;

class IDMustBeInt extends BaseValidate{
    protected $rule = [
        "id" => "require|checkID"
    ];
    
    protected $message = [
        "id" => "id值必须是正整数"
    ];
}