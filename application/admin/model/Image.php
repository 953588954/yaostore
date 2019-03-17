<?php
namespace app\admin\model;

use think\Model;
class Image extends Model{
    protected $autoWriteTimestamp = true;
    
    //图片路径获取器 返回如 http://www.hkj.cn/uploads/...
    public function getImaUrlAttr($value){
        $val = str_replace("\\", "/", $value);  //防止在win平台转到linux系统下的路径错误
        return config("queue.basic_url")."uploads/".$val;
    }
}