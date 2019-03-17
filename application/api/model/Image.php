<?php
namespace app\api\model;

use think\Model;
class Image extends Model{
    protected $hidden = ['create_time','update_time','delete_time'];
    
    protected $autoWriteTimestamp = true;
    
    //img路径获取器
    public function getImaUrlAttr($value){
        $val = str_replace('\\', '/', $value);
        return config('queue.basic_url').'uploads/'.$val;
    }
}