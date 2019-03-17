<?php
namespace app\admin\validate;

class AddProduct extends BaseValidate{
    protected $rule = [
        'name'  =>  "require|isNotEmpty|length:1,40",
        'specification' => "require|isNotEmpty|length:1,40",
        'price' =>  "require|isNotEmpty|checkPrice",
        'stock' =>  "require|isNotEmpty|checkID",
        'dosage' => "require|checkID",
        'category' => "require|checkID",
        'after_sale' => "require|isNotEmpty"
        
    ];
    
    protected $message = [
        'name' => '商品名必须是1~40位字符',
        'specification' => '商品规格必须是1~40位字符',
        'price' => '价格必须是大于0的数',
        'stock' => '库存必须是正整数',
        'dosage' => '请选择剂型',
        'category' => '请选择分类',
        'after_sale' => '请填写售后说明'
    ];
}