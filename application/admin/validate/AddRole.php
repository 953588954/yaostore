<?php
/*
 * 添加角色验证器
 */


namespace app\admin\validate;

class AddRole extends BaseValidate{
    protected $rule = [
        'role_name' =>'require|isNotEmpty'
    ];
    
    protected $message = [
        'role_name' => '角色名不能为空'
    ];
}