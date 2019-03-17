<?php
namespace app\admin\validate;

class AddAuth extends BaseValidate{
    protected $rule = [
        "auth_name" => "require|isNotEmpty",
        "auth_pid" => "require|number",
    ];
}