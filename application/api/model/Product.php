<?php
namespace app\api\model;

use think\Model;
use app\lib\exception\ProductException;
class Product extends Model{
    protected $hidden = ['create_time','update_time','delete_time'];
    
    //商品头图 关联Image
    public function topicImg(){
        return $this->belongsTo("Image","main_img_id","ima_id");
    }
    
    //关联商品所有图片
    public function productImgs(){
        return $this->hasMany('Image','product_id','pro_id');
    }
    
    //关联剂型
    public function dosage(){
        return $this->belongsTo("Dosage","dosage_id","dos_id");
    }
    
    /*
     * 根据商品id获取详细信息
     */
    public function getProductDetailInfo($id){
        $rst = self::with(['productImgs','dosage'])->where(['pro_is_onsale'=>1,'pro_id'=>$id])->find();
        if (!$rst){
            throw new ProductException();
        }
        return $rst;
    }
    
    /*
     * 根据商品id获取信息，查不到 如实返回
     */
    public function getProInfo($id){
        $rst = self::with('topicImg')->where(['pro_is_onsale'=>1,'pro_id'=>$id])->find();
        return $rst;
    }
    
    /*
     * 搜索商品
     */
    public function searchPros($str){
        $rst = self::with('topicImg')->where('pro_is_onsale',1)->where('pro_char','like',$str.'%')->select();
        return $rst;
    }
}