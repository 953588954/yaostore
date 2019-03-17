<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\Category as CategoryModel;
use app\lib\exception\BannerException;
use app\api\validate\GetProductsByCatgory;
class Category extends BaseController{
    protected $beforeActionList = [
        'checkAuth' => ['only'=>'getAllCategory,getProductsByCategory']
    ];
    
    /*
     * 获取所有分类
     */
    public function getAllCategory(){
        $catModel = new CategoryModel();
        $rst = $catModel->select();
        if (!$rst){
            throw new BannerException(['msg'=>'没有查到分类','errorCode'=>10004]);
        }else{
            return json($rst);
        }
    }
    
    
    /*
     * 根据分类id 头图id 获取分类头图 和商品
     * @param int cat_id 分类主键id
     * @param int topic_img_id 分类头图关联图片id
     */
    public function getProductsByCategory(){
        (new GetProductsByCatgory())->goCheck();
        
        $cat_id = input('param.cat_id');
//         $topic_img_id = input('param.topic_img_id');
        
        $catModel = new CategoryModel();
        $catInfo = $catModel->getCatInfo($cat_id);   //单个分类信息
        $proInfo = $catModel->getProductsByCatId($cat_id);  //商品信息
        
        return json([
            'catInfo' => $catInfo,
            'proInfo' => $proInfo
        ]);
    }
    
    
    
}