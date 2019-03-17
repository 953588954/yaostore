<?php
namespace app\admin\model;

use think\Model;
class Theme extends Model{
    //关联img
    public function img(){
        return $this->belongsTo("Image","topic_img_id","ima_id");
    }
    
    /*
     * 取所有主题
     */
    public function getThemes(){
        return self::with('img')->select();
    }
}