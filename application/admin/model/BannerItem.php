<?php
namespace app\admin\model;

use think\Model;
class BannerItem extends Model{
    
    /*
     * 查询所有轮播图
     */
    public function getBannerInfo(){
        return self::with(["img","product"=>function($query){
            $query->with('cate');
        }])->select();
    }
    //跟image表关联
    public function img(){
        return $this->belongsTo("Image","img_id","ima_id");
    }
    //跟商品表关联
    public function product(){
        return $this->belongsTo("Product","product_id","pro_id");
    }
    
    /*
     * 多图上传
     * @return 上传成功图片的数量
     */
    public function upload_banners($proId){
        
        $file = request()->file("banner_img");
        if ($file){
            
            $info = $file->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,jpeg,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
            if ($info){
                $img_url = $info->getSaveName();    //图片路径
                //保存路径
                $imageModel = new Image();
                $imageModel->ima_url = $img_url;
                $imageModel->save();
                $img_id = $imageModel->ima_id;
                self::create(['img_id'=>$img_id,'product_id'=>$proId]);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    /*
     * 启用轮播图
     */
    public function useBannerImg($bannerId,$isUse){
        //计算目前启用的轮播图数量
        $count = self::where("is_use","=","1")->count();
        
        if ($isUse==1){//添加启用数量
            if ($count>5)
                return false;
            $state = 1;
        }else{  //减少数量
            if ($count<5)
                return false;
            $state = 0;
        }

        self::save(['is_use'=>$state],['ban_id'=>$bannerId]);
        return true;

    }
    
    /*
     * 删除轮播图
     */
    public function delBannerImg($banId){
        //判断此轮播图是否是启用状态
        $bannerInfo = self::where("ban_id",$banId)->find();

        if ($bannerInfo['is_use']==1){
            return false;
        }
        //删除图片 及 记录
        $imgModel = new Image();
        $imgInfo = $imgModel->where("ima_id",$bannerInfo['img_id'])->find();
        $beforUrl = $imgInfo->getData('ima_url');
        $url = str_replace("\\", "/", $beforUrl);
        unlink(ROOT_PATH."/public/uploads/".$url);
        $imgModel->where("ima_id",$bannerInfo['img_id'])->delete();
        //删除banner记录
        self::where("ban_id",$banId)->delete();
        return true;
    }
    
    
    
    
}