<?php
namespace app\api\model;

use think\Model;
use app\lib\exception\ProductException;
class Address extends Model{
    protected $hidden = ['create_time','update_time'];
    
    /*
     * 根据用户收货地址信息  查询运费
     * return postagePrice,notPass
     */
    public static function getPostageByAddressInfo($proArr,$addressInfo){
        $isPostage = false; //初始化  没有邮费
        $proModel = new Product();
        foreach ($proArr as $pro){
            $postageRst = self::checkPostageById($proModel, $pro['id']);
            if ($postageRst==1){
                $isPostage = true;
            }
        }
        //根据地址 查询 该地区是否配送
        $freightModel = new Freight();
        $provinceInfo = $freightModel->where("fre_region",$addressInfo['add_province'])->find();
        if (!$provinceInfo){    //如果省份没有找到，则不配送
            return ['postagePrice'=>0,'notPass'=>1];
        }else{
            if ($provinceInfo['fre_price']==-1){    //如果省级别 -1，则表示不配送
                return ['postagePrice'=>0,'notPass'=>1];
            }

            $municipalitys = ['北京市','上海市','天津市','重庆市'];
            if (array_key_exists($addressInfo['add_province'], $municipalitys)){    //如果是直辖市
                $countryInfo = $freightModel->where(['fre_pid'=>$provinceInfo['fre_id'],'fre_region'=>$addressInfo['add_country']])->find();
                if (!$countryInfo){ //如果没有找到区 
                    return ['postagePrice'=>0,'notPass'=>1];
                }else{
                    if ($countryInfo['fre_price']==-1){ //区设置了不配送
                        return ['postagePrice'=>0,'notPass'=>1];
                    }
                    if ($isPostage){    //商品不全是包邮的
                        //找到了区，查看上级省份是否设置了运费
                        if ($provinceInfo['fre_price']!=0){
                            $price = $provinceInfo['fre_price']<0?0:$provinceInfo['fre_price'];
                            return ['postagePrice'=>$price,'notPass'=>0];
                        }else{
                            $price = $countryInfo['fre_price']<0?0:$countryInfo['fre_price'];
                            return ['postagePrice'=>$price,'notPass'=>0];
                        }
                    }else{
                        return ['postagePrice'=>0,'notPass'=>0];
                    }
                    
                }
            }else{
                $cityInfo = $freightModel->where(['fre_pid'=>$provinceInfo['fre_id'],'fre_region'=>$addressInfo['add_city']])->find();
                if (!$cityInfo){ //如果没有找到市
                    return ['postagePrice'=>0,'notPass'=>1];
                }else{
                    if ($cityInfo['fre_price']==-1){ //市设置了不配送
                        return ['postagePrice'=>0,'notPass'=>1];
                    }
                    if ($isPostage){    //商品不全是包邮的
                        //找到了区，查看上级省份是否设置了运费
                        if ($provinceInfo['fre_price']!=0){
                            $price = $provinceInfo['fre_price']<0?0:$provinceInfo['fre_price'];
                            return ['postagePrice'=>$price,'notPass'=>0];
                        }else{
                            $price = $cityInfo['fre_price']<0?0:$cityInfo['fre_price'];
                            return ['postagePrice'=>$price,'notPass'=>0];
                        }
                    }else{
                        return ['postagePrice'=>0,'notPass'=>0];
                    }
                
                }
            }
        }
    }
    
    /*
     * 根据商品id 获取 是否有运费
     */
    protected static function checkPostageById($proModel,$id){
        
        $proInfo = $proModel->where(["pro_id"=>$id,"pro_is_onsale"=>1])->find();
        if (!$proInfo){
            throw new ProductException(['msg'=>'传入商品id有误或商品已下架']);
        }
        return $proInfo['pro_postage'];
    }
}