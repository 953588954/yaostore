<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\lib\exception\ParamertersException;
use app\api\model\Product;
class Cart extends BaseController{
    protected $beforeActionList = [
        'checkAuth' => ['only'=>'checkCartProducts']
    ];
    
    /*
     * 检查购物车中商品
     * POST
     * @param array cartProducts 二维数组 [id,counts,isSelect]
     * @return 二维数组 [id,name,price,imgUrl,postage,counts,isSelect]
     * 如果某一个商品id未查到数据，则返回 [id,notPass]
     */
    public function checkCartProducts(){
        $productArr = input('post.cartProducts/a');
        if (empty($productArr)){
            throw new ParamertersException(['msg'=>'请传入参数cartProducts数组形式']);
        }
        //循环检查 参数
        foreach ($productArr as $val){
            if (!isset($val['id']) || !isset($val['counts']) || !isset($val['isSelect'])){
                throw new ParamertersException(['msg'=>'传入参数列表有误,必须存在id、counts、isSelect']);
            }
        }
        //查询信息
        $productInfo = $this->getProductsInfo($productArr);
        
        return json($productInfo);
    }
    
    /*
     * 查询所有商品信息，组装好数据返回
     */
    private function getProductsInfo($productArr){
        $prosArr = [];
        foreach ($productArr as $product){
            $arr = $this->getProductDetail($product);
            array_push($prosArr, $arr);
        }
        return $prosArr;
    }
    
    /*
     * 查询某一个商品详细信息
     * return array 一维数组
     */
    private function getProductDetail($product){
        $proArr = [];
        
        $id = $product['id'];
        $proModel = new Product();
        $rst = $proModel->getProInfo($id);
        if ($rst){
            $proArr['id'] = $id;
            $proArr['name'] = $rst['pro_name'];
            $proArr['price'] = $rst['pro_price'];
            $proArr['imgUrl'] = $rst['topic_img']['ima_url'];
            $proArr['postage'] = $rst['pro_postage'];
            $proArr['counts'] = $product['counts'];
            $proArr['isSelect'] = $product['isSelect'];
        }else{
            $proArr['id'] = $id;
            $proArr['notPass'] = true;
        }
        return $proArr;
    }
    
    
    
    
    
    
    
}