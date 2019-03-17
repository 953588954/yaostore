<?php
namespace app\admin\validate;

class AddStore extends BaseValidate{
    protected $rule = [
        "bus_name" => "require|isNotEmpty",
        "bus_open_time" => "require|isNotEmpty",
        "bus_open_day" => "require|isNotEmpty",
        "phone" => "require|isNotEmpty|number",
        "bus_address" => "require|isNotEmpty"
    ];
    
    protected $message = [
        "bus_name" => "店铺名不能为空",
        "bus_open_time" => "营业时间不能为空不能为空",
        "bus_open_day" => "开店周不能为空",
        "phone" => "电话必须为数字",
        "bus_address" => "店铺地址不能为空",
    ];
}