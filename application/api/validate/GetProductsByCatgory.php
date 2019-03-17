<?php
namespace app\api\validate;

class GetProductsByCatgory extends BaseValidate{
    protected $rule = [
        'cat_id' => 'require|checkId'
//         'topic_img_id' => 'require|checkId'
    ];
    
    protected $message = [
        'cat_id' => '分类cat_id必须存在且是正整数'
//         'topic_img_id' => '分类头图topic_img_id必须存在且是正整数'
    ];
}