<?php
namespace app\api\model;

use think\Model;
class BannerItem extends Model{
    protected $hidden = ['img_id'];
    /*
     * 关联image模型
     */
    public function imgUrl(){
        return $this->belongsTo("Image","img_id","ima_id");
    }
    
    /*
     * 获取启用的轮播图 倒叙
     */
    public function getBannerItems(){
        return self::with('imgUrl')->where('is_use',"=","1")->order('ban_id desc')->select();
    }
}