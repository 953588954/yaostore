<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use hanziToPinyin\ChinesePinyin;
class Product extends Model{
    protected $autoWriteTimestamp = true;
    
    //关联image表 商品头图
    public function mainImg(){
        return $this->belongsTo("Image","main_img_id","ima_id");
    }
    //关联category表
    public function cate(){
        return $this->belongsTo("Category","category_id","cat_id");
    }
    //关联image表 商品所有图片
    public function imgs(){
        return $this->hasMany("Image","product_id","pro_id");
    }
    
    /*
     * 保存商品
     */
    public function addAndUpload($params,$files){
        $chinese = $params['name'];
        $pinyin = new ChinesePinyin();
        $name_char = $pinyin->TransformUcwords($chinese);
        $name_char = strtolower($name_char);
        
        Db::startTrans();   //启动事务
        $this->data([
            'pro_name' => $params['name'],
            'pro_char' => $name_char,
            'pro_producer' => $params['producer'],
            'pro_approval_number' => $params['approval_number'],
            'pro_deposit' => $params['deposit'],
            'pro_specification' => $params['specification'],
            'pro_effect' => $params['effect'],
            'pro_taboo' => $params['taboo'],
            'pro_after_sale_description' => $params['after_sale'],
            'pro_stock' => $params['stock'],
            'pro_price' => $params['price'],
            'pro_postage' => $params['freight'],
            'pro_is_hot' => $params['is_hot'],
            'pro_is_onsale' => $params['is_onsale'],
            'pro_is_recommend' => $params['is_recommend'],
            'dosage_id' => $params['dosage'],
            'category_id' => $params['category'],
            'pro_brand' => $params['brand']
        ]);
        $this->save();
        $productId = $this->getAttr('pro_id'); //增加商品后 得到 商品id，用来上传关联图片
        //多图上传
        
        $count = 0;
        foreach ($files as $file){
            $info = $file->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,jpeg,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $imgModel = new Image();
                $imgName = $info->getSaveName();    //图片路径
                $imgModel->ima_url = $imgName;
                $imgModel->product_id = $productId;
                $imgModel->save();
                //设置第一张图片为默认商品主图
                if ($count==0){
                    $imgId = $imgModel->ima_id;
                    $this->save(['main_img_id'=>$imgId],['pro_id'=>$productId]);
                }
                $count++;
                if ($count==5){ //上传5张图片后 直接 跳出循环
                    break;
                }
            }
        }
        if ($count==0){
            Db::rollback(); //事务回滚
            return false;
        }else{
            Db::commit();   //事务提交
            return true;
        }
    }
    
    /*
     * 根据条件查询商品
     * @param array $param
     * return array count查询商品数量 result查询商品信息
     */
    public function getProducts($param){
        $array = [];
        //分类条件
        if ($param['category']!=0){
            $array['category_id'] = $param['category'];
        }
        //剂型条件
        if ($param['dosage']!=0){
            $array['dosage_id'] = $param['dosage'];
        }
        //是否免邮
        if ($param['postage']!=3){
            $array['pro_postage'] = $param['postage'];
        }
        //是否热卖
        if ($param['is_hot']!=3){
            $array['pro_is_hot'] = $param['is_hot'];
        }
        //是否推荐
        if ($param['is_recommend']!=3){
            $array['pro_is_recommend'] = $param['is_recommend'];
        }
        //是否上架
        if ($param['is_onsale']!=3){
            $array['pro_is_onsale'] = $param['is_onsale'];
        }
        $count = self::where($array)->count();
        $result = self::with(['mainImg','cate'])->where($array)->paginate(10);
        return [
            'count' => $count,
            'result' => $result
        ];
    } 
    
    /*
     * 根据商品id查询详细信息
     * 
     */
    public function getProInfoById($proId){
        return self::where("pro_id","=",$proId)->find();
    }
    
    
    
    
    
}