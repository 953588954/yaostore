<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use think\Db;
use app\lib\exception\BaseException;
use app\api\validate\ProductId;
use app\api\model\Product as ProductModel;
use app\lib\exception\ParamertersException;
use hanziToPinyin\ChinesePinyin;
class Product extends BaseController{
     protected $beforeActionList = [
        'checkAuth' => ['only'=>'getRandomProducts,getProductInfoById,searchProducts']
     ];
    
    /*
     * 获取首页随机10条数据
     */
    public function getRandomProducts(){
        $sql = "select pro_id,pro_name,pro_price,ima_url from product left join image on main_img_id=ima_id where pro_is_onsale=1 and pro_id>=round(rand()*((select max(pro_id) from product)-(select min(pro_id) from product))) order by pro_id limit 10";
        $products = Db::query($sql);
        if (empty($products)){
            throw new BaseException(['msg'=>'没有查到商品数据','code'=>404,'errorCode'=>10003]);
        }
        //循环改变图片路径 为 全路径
        foreach ($products as &$product){
            $url = str_replace("\\", "/", $product['ima_url']);
            $product['ima_url'] = config("queue.basic_url")."uploads/".$url;
        }
        return json($products);
    }
    
    /*
     * 获取某一个商品的详细信息
     * @url GET
     * @param int id
     */
    public function getProductInfoById(){
        (new ProductId())->goCheck();
        $id = input('get.id');
        $proModel = new ProductModel();
        $rst = $proModel->getProductDetailInfo($id);
        return json($rst);
    }
    
    /*
     * 搜索商品
     * POST
     * @param string searchStr
     */
    public function searchProducts(){
        $proChar = input('post.searchStr');
        if (empty($proChar)){
            throw new ParamertersException(['msg'=>'搜索参数不能为空']);
        }
        
        $pinyin = new ChinesePinyin();
        $str = $pinyin->TransformUcwords($proChar);
        $str = strtolower($str);
        
        $proModel = new ProductModel();
        $result = $proModel->searchPros($str);
        if (!$result){
            return json([
                'searchProducts' => ''
            ]);
        }
        $result = collection($result)->visible(['pro_id','pro_name','pro_price','topic_img'])->toArray();
        
        return json([
            'searchProducts' => $result
        ]);
        
    }
    
    
    
    
    
    
    
    
    
    
}