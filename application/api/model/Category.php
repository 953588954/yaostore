<?php
namespace app\api\model;

use think\Model;
use app\lib\exception\BannerException;
class Category extends Model{
    protected $hidden = ['create_time','update_time','delete_time'];
    
    //关联image
    public function img(){
        return $this->belongsTo("Image","cat_topic_img_id","ima_id");
    }
    
    /*
     * 根据分类id获取某一分类信息
     */
    public function getCatInfo($catId){
        $rst = self::with('img')->where("cat_id",$catId)->find();
        if (empty($rst)){
            throw new BannerException(['msg'=>'没有查到分类信息','errorCode'=>10005]);
        }
        return $rst;
    }
    
    /*
     * 根据分类id 获取 所有商品
     */
    public function getProductsByCatId($cat_id){
        $proModel = new Product();
        $rst = $proModel->with('topicImg')->where(["category_id"=>$cat_id,'pro_is_onsale'=>1])->select();
        if (empty($rst)){
            return [];
        }
        $rst = collection($rst)->visible(['pro_id','pro_price','pro_name','topic_img'])->toArray();
        return $rst;
    }
    
}