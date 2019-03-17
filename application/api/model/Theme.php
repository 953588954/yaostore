<?php
namespace app\api\model;

use think\Model;
use app\lib\exception\ParamertersException;
class Theme extends Model{
    
    //关联Image表
    public function img(){
        return $this->belongsTo("Image","topic_img_id","ima_id");
    }
    
    /*
     * 获取主题头图 及 商品信息
     * 每次根据page参数 获取11条数据
     */
    public function getInfoByParam($theme,$page=1,$size=11){
//         $array = [];
        $ProModel = new Product();
        if ($theme=='all'){ //获取主题id=1 图片及所有商品
            $theInfo = self::with('img')->where('the_id',1)->find();
            $proInfo = $ProModel->with('topicImg')->where('pro_is_onsale',1)->limit(($page-1)*$size,$size)->select();
            
        }elseif ($theme=='new'){    //获取主题id=2 图片及最新商品
            $theInfo = self::with('img')->where('the_id',2)->find();
            $proInfo = $ProModel->with('topicImg')->order('create_time desc')->where('pro_is_onsale',1)->limit(($page-1)*$size,$size)->select();
            
        }elseif ($theme=='hot'){    //获取主题id=3 图片及热卖商品
            $theInfo = self::with('img')->where('the_id',3)->find();
            $proInfo = $ProModel->with('topicImg')->where('pro_is_hot',1)->where('pro_is_onsale',1)->limit(($page-1)*$size,$size)->select();
            
        }elseif ($theme=='recommend'){  //获取主题id=4 图片及推荐商品
            $theInfo = self::with('img')->where('the_id',4)->find();
            $proInfo = $ProModel->with('topicImg')->where('pro_is_recommend',1)->where('pro_is_onsale',1)->limit(($page-1)*$size,$size)->select();
            
        }elseif ($theme=='postage'){    //获取主题id=5 图片及包邮商品
            $theInfo = self::with('img')->where('the_id',5)->find();
            $proInfo = $ProModel->with('topicImg')->where('pro_postage',0)->where('pro_is_onsale',1)->limit(($page-1)*$size,$size)->select();
            
        }else{
            throw new ParamertersException();
        }
        
        return ['theInfo'=>$theInfo,'proInfo'=>$proInfo];
    }
}