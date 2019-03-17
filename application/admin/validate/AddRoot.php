<?php
/*
 * 添加管理员 验证器
 */

namespace app\admin\validate;

class AddRoot extends BaseValidate{
    protected $rule = [
        'root_name' => 'require|isNotEmpty|max:15',
        'root_sex' => 'require|isNotEmpty|in:1,2,3',
        'root_username' => 'require|isNotEmpty|alphaNum|length:5,16',
        'root_pwd' => 'require|isNotEmpty|alphaNum',
        'root_phone' => 'require|isNotEmpty|number|length:11',
        'role_id' => 'require|isNotEmpty|number|notIn:0'
    ];
    
    protected $message = [
        'root_name.max' => '姓名不能超过15个字符长度',
        'root_username.length'=>'账号长度必须在5-16位字符或数字',
        'root_phone.length'=>'请输入正确手机号码',
        'role_id' => '请选择角色'
    ];
}