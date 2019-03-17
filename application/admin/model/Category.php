<?php
namespace app\admin\model;

use think\Model;
class Category extends Model{
    protected $autoWriteTimestamp = true;
    
    //关联image模型
    public function img(){
        return $this->belongsTo("Image","cat_topic_img_id","ima_id");
    }
    
    /*
     * 获取所有分类
     */
    public function getCategorys(){
        return self::with("img")->select();
    }
    
    /*
     * 获取一条分类
     */
    public function getCategoryById($id){
        return self::with("img")->where("cat_id","=",$id)->find();
    }
}