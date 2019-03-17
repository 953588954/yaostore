<?php
namespace app\admin\controller;

use app\admin\model\Freight;
use app\admin\validate\AddProduct;
use app\admin\model\Product as ProductModel;
use app\admin\model\Dosage;
use app\admin\model\Image;
use app\admin\model\Category;
use app\admin\validate\EditProduct;
class Product extends BaseController{
    
    /*
     * 运费模板
     */
    public function freight(){
        $freightModel = new Freight();
        $provinces = $freightModel->where("fre_pid","=","0")->select(); //所有一级省份
        
        $beijing = $freightModel->where("fre_id","=","1")->find();      //获取北京市信息
        $regions = $freightModel->where("fre_pid","=","1")->select();   //获取北京市 二级地区
        
        $this->assign('provinces',$provinces);
        $this->assign("sheng",$beijing);
        $this->assign("regions",$regions);
        $this->assign('navigation1','商品管理');
        $this->assign('navigation2','运费设置');
        return view('freight');
    }
    /*
     * 添加一级省份、直辖市、自治区
     */
    public function provinceAdd(){
        $province_name = input('param.province_name');
        if($province_name==""){
            $this->error("省份不能为空","freight");exit;
        }
        $freightModel = new Freight();
        $freightModel->fre_region = $province_name;
        $freightModel->save();
        $this->success("添加成功",'freight');
    }
    /*
     * 添加二级市区
     */
    public function regionAdd(){
        $region = input("post.region_name/a"); //接收城市 一维数组
        $pid = input('param.pid');  //父id
        if ($pid==0){
            $this->error("请选择省份/直辖市/自治区","freight");exit;
        }
        $freightModel = new Freight();
        $list = [];        
        //去除数组 空值
        $length = count($region);
        for($i=0;$i<$length;$i++){
            if (empty($region[$i])){
                continue;
            }
            $arr = ['fre_region'=>$region[$i],'fre_pid'=>$pid];
            array_push($list, $arr);
        }
        //批量添加
        $freightModel->saveAll($list);
        $this->success("添加成功","freight");
    }
    /*
     * 获取省份及省份的下属市区 ajax
     * @param int province_id 省份id
     * return json
     */
    public function getRegionsByAjax(){
        $provinceId = input("param.province_id");
        //checkID($provinceId);   //检测id是否是正整数
        $freightModel = new Freight();
        $province = $freightModel->where('fre_id',"=",$provinceId)->find(); //省份
        $regions = $freightModel->where("fre_pid","=",$provinceId)->select();   //市区
        echo json_encode([
            'error' => 0,
            'data' => $regions,
            'province' => $province
        ]);
        exit;
    }
    
    /*
     * 删除 省份 或者 市区
     */
    public function delProvinceOrRegion(){
        $provinceId = input("param.province");
        $regionId = input("param.region");
        if ($provinceId==0){
            $this->error("请选择省份","Product/freight");exit;
        }
        $freightModel = new Freight();
        //删除该省份 及下属所有地区
        if ($regionId==0){
            $freightModel->where("fre_id","=",$provinceId)->whereOr("fre_pid","=",$provinceId)->delete();
        }else{
            $freightModel->where("fre_id","=",$regionId)->delete();
        }
        $this->success("删除成功","freight");
    }
    
    /*
     * ajax 通过id 修改运费
     * @param int fre_id 省市区id
     * @param float price 运费
     * return json
     */
    public function editPriceById(){
        $freId = input("param.fre_id");
        $price = input("param.price");
        if(!is_numeric($freId) || $freId<1){
            echo json_encode([
                'error' => 1,
                'msg'   => "传入id不合法"
            ]);
            exit;
        }
        if (!is_numeric($price) || ($price<0 && $price != -1)){
            echo json_encode([
                'error' => 1,
                'msg'   => "运费不合法"
            ]);
            exit;
        }
        $freightModel = new Freight();
        $freightModel->save(['fre_price'=>$price],['fre_id'=>$freId]);
        echo json_encode([
            'error' => 0,
            'data'   => ['fre_id'=>$freId]
        ]);
        exit;
    }
    
    /*
     * 添加商品页
     */
    public function productAddIndex(){
        //所有剂型
        $dosageModel = new Dosage();
        $dosages = $dosageModel->select();
        //所有分类
        $categoryModel = new Category();
        $categorys = $categoryModel->select();
        
        $this->assign('dosages',$dosages);
        $this->assign("categorys",$categorys);
        $this->assign('navigation1','商品管理');
        $this->assign('navigation2','添加商品');
        return view('productAddIndex');
    }
    /*
     * 添加商品
     */
    public function addProduct(){
        (new AddProduct('Product/productAddIndex'))->goCheck();
        
        $params = input('param.');
        $files = request()->file('img');
        //保存商品及图片
        $productModel = new ProductModel();
        $rst = $productModel->addAndUpload($params,$files);
        if($rst===false){
            $this->error("添加失败，请确保上传的商品图片是png,jpg,jpeg,gif格式的，且图片大小小于2M",'productAddIndex');exit;
        }
        $this->success("添加成功",'productAddIndex');
    }
    
    /*
     * 添加剂型
     */
    public function addDosage(){
        $dosName = input('post.dosage');
        if ($dosName==""){
            $this->error("请填写剂型名","productAddIndex");exit;
        }
        $dosageModel = new Dosage();
        $dosageModel->dos_name = $dosName;
        $dosageModel->save();
        $this->success("添加成功",'productAddIndex');
    }
    
    /*
     * 商品分类页
     */
    public function category(){
        //查询所有分类
        $categoryModel = new Category();
        $categorys = $categoryModel->getCategorys();
        
        $this->assign('categorys',$categorys);
        $this->assign('navigation1','商品管理');
        $this->assign('navigation2','商品分类');
        return view('category');
    }
    /*
     * ajax通过id 获取一条分类信息
     */
    public function getCategoryById(){
        $id = input('get.id');
        $categoryModel = new Category();
        $category = $categoryModel->getCategoryById($id);
        if ($category){
            echo json_encode([
                'error' => 0,
                'data' => $category
            ]);
            exit;
        }else{
            echo json_encode([
                'error' => 1,
                'msg' => "没有查到数据"
            ]);
            exit;
        }
    }
    /*
     * 编辑分类
     */
    public function editCategory(){
        $id = input('post.cat_id');
        $name = input('post.category');
        if (!is_numeric($id)){
            $this->error("参数id错误","category"); exit;
        }
        if ($name==""){
            $this->error("分类名称不能为空","category"); exit;
        }
        //修改分类名称
        $categoryModel = new Category();
        $catInfo = $categoryModel->where("cat_id","=",$id)->find();
        $categoryModel->save(['cat_name'=>$name],['cat_id'=>$id]);
        
        $file = request()->file('topic_img');
        if ($file){
            $info = $file->validate(['size'=>1024*1024*2,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info){
                $imgUrl = $info->getSaveName(); //图片路径
                $ImageModel = new Image();
                //查找更新前图片路径
                $beforImg = $ImageModel->where("ima_id","=",$catInfo['cat_topic_img_id'])->find();
                //更新图片路径
                $ImageModel->save(['ima_url'=>$imgUrl],['ima_id'=>$catInfo['cat_topic_img_id']]);
                //删除以前图片
                $url = $beforImg->getData('ima_url');
                $url = str_replace("\\", "/", $url);
                unlink(ROOT_PATH."/public/uploads/".$url);
            }
        }
        $this->success("更新成功","category");
    }
    /*
     * 删除分类
     */
    public function deleteCategory(){
        $id = input("param.id");
        $productModel = new ProductModel();
        $info = $productModel->where('category_id','=',$id)->select();
        if ($info){
            $this->error('此分类下还有商品，删除失败','category');exit;
        }else{
            $categoryModel = new Category();
            $beforInfo = $categoryModel->where("cat_id","=",$id)->find();//删除前数据
            //查找删除前图片路径
            $imgModel = new Image();
            $beforImg = $imgModel->where("ima_id","=",$beforInfo['cat_topic_img_id'])->find();
            //删除以前图片
            $url = $beforImg->getData('ima_url');
            $url = str_replace("\\", "/", $url);
            unlink(ROOT_PATH."/public/uploads/".$url);
            //删除分类
            $categoryModel->where("cat_id","=",$id)->delete();
            //删除图片表记录
            $imgModel->where("ima_id","=",$beforInfo['cat_topic_img_id'])->delete();
            $this->success("删除成功","category");
        }
    }
    
    /*
     * 添加分类
     */
    public function addCategory(){
        $catName = input('post.category');
        if ($catName==""){
            $this->error("请填写分类名","category");exit;
        }
        //上传头图
        $file = request()->file('topic_img');
        //var_dump($file);die;
        if ($file){
            $info = $file->validate(['size'=>1024*1024*2,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info){
                //保存图片
                $imgUrl = $info->getSaveName();
                $imgModel = new Image();
                $imgModel->ima_url = $imgUrl;
                $imgModel->save();
                $imgId = $imgModel->ima_id;
                //保存分类
                $categoryModel = new Category();
                $categoryModel->cat_name = $catName;
                $categoryModel->cat_topic_img_id = $imgId;
                $categoryModel->save();
                $this->success("添加成功","category");exit;
            }else{
                $this->error("上传图片失败：".$file->getError(),"category");exit;
            }
        }else{
            $this->error("请上传正确图片","category");exit;
        }
    }
    
    /*
     * 商品列表页
     */
    public function product(){
        $param = input("param.");
        //整合param参数
        $param = $this->conformParam($param);
        //根据条件查询商品
        $productModel = new ProductModel();
        $resInfo = $productModel->getProducts($param);
        $products = $resInfo['result']; //查询出的数据
        //分页
        $page = $products->render();
        
        //所有分类
        $categoryModel = new Category();
        $categorys = $categoryModel->select();
        //所有剂型
        $dosageModel = new Dosage();
        $dosages = $dosageModel->select();
        
        $this->assign("page",$page);
        $this->assign('products',$products);
        $this->assign('param',$param);
        $this->assign('categorys',$categorys);
        $this->assign('dosages',$dosages);
        $this->assign('count',$resInfo['count']);   //查询总记录数
        $this->assign('navigation1','商品管理');
        $this->assign('navigation2','所有商品');
        return view('product');
    }
    //整合param参数
    private function conformParam($param){
        $array = [];
        //分类条件
        if (isset($param['category']) && is_numeric($param['category'])){
            $array['category'] = $param['category'];
        }else{
            $array['category'] = 0;
        }
        //剂型条件
        if (isset($param['dosage']) && is_numeric($param['dosage'])){
            $array['dosage'] = $param['dosage'];
        }else{
            $array['dosage'] = 0;
        }
        //是否免邮
        if (isset($param['postage']) && is_numeric($param['postage']) && $param['postage']!=3){
            $array['postage'] = $param['postage'];
        }else{
            $array['postage'] = 3;
        }
        //是否热卖
        if (isset($param['is_hot']) && is_numeric($param['is_hot']) && $param['is_hot']!=3){
            $array['is_hot'] = $param['is_hot'];
        }else{
            $array['is_hot'] = 3;
        }
        //是否推荐
        if (isset($param['is_recommend']) && is_numeric($param['is_recommend']) && $param['is_recommend']!=3){
            $array['is_recommend'] = $param['is_recommend'];
        }else{
            $array['is_recommend'] = 3;
        }
        //是否上架
        if (isset($param['is_onsale']) && is_numeric($param['is_onsale']) && $param['is_onsale']!=3){
            $array['is_onsale'] = $param['is_onsale'];
        }else{
            $array['is_onsale'] = 3;
        }
        return $array;
    }
    
    /*
     * 编辑商品 商品详情
     */
    public function editProduct(){
        $proId = input("param.pro_id");
       // var_dump($proId);die;
        if (!is_numeric($proId) || ($proId+0)<1 || !is_int($proId+0)){
            $this->error("请选择正确商品id","product"); exit;
        }
        //根据商品id 查询信息
        $productModel = new ProductModel();
        $proInfo = $productModel->getProInfoById($proId);
        //查询商品图片
        $ImageModel = new Image();
        $imgInfo = $ImageModel->where("product_id",$proId)->select();
        //查询所有分类
        $categoryModel = new Category();
        $catInfo = $categoryModel->select();
        //查询所有剂型
        $dosageModel = new Dosage();
        $dosInfo = $dosageModel->select();
        
        $this->assign("proInfo",$proInfo);
        $this->assign("catInfo",$catInfo);
        $this->assign("dosInfo",$dosInfo);
        $this->assign("proId",$proId);
        $this->assign("imgInfo",$imgInfo);
        $this->assign('navigation1','商品管理');
        $this->assign('navigation2','商品详情');
        return view('editProduct');
    }
    
    /*
     * 删除商品某一张图片
     */
    public function delProImgByImgId(){
        $imgId = input("param.img_id");
        $proId = input("param.pro_id");
        //判断图片于商品是否管理
        $imgModel = new Image();
        $imgInfo = $imgModel->where("ima_id",$imgId)->find();
        if ($imgInfo->product_id != $proId){
            $this->error("删除的图片与商品不对应","editProduct?pro_id={$proId}");exit;
        }
        //判断图片是否是该商品主图
        $proModel = new ProductModel();
        $proInfo = $proModel->where("pro_id",$proId)->find();
        if ($proInfo->main_img_id == $imgId){
            $this->error("商品的主图不能删除","editProduct?pro_id={$proId}");exit;
        }
        //根据路径删除图片
        $url = $imgInfo->getData('ima_url');
        $url = str_replace("\\", "/", $url);
        unlink(ROOT_PATH."/public/uploads/".$url);
        //删除数据库记录
        $imgModel->where("ima_id",$imgId)->delete();
        
        $this->success("删除成功","editProduct?pro_id={$proId}");
    }
    
    /*
     * 提交编辑商品
     */
    public function editProductSubmit(){
        $proId = input("param.pro_id");
        //echo $proId;die;
        (new EditProduct("Product/editProduct?pro_id={$proId}"))->goCheck();
        
        //查出此商品的商品图数量
        //上传图片 不得超出5张
        $imgModel = new Image();
        $imgCounts = $imgModel->where("product_id",$proId)->count();
        if ($imgCounts<5){
            $files = request()->file('imgs');
            
            foreach ($files as $file){
                $info = $file->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,jpeg,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info){
                    $img_url = $info->getSaveName();    //上传图片路径
                    $imgModel = new Image();
                    $imgModel->ima_url = $img_url;
                    $imgModel->product_id = $proId;
                    $imgModel->save();
                    $imgCounts++;
                }
                if ($imgCounts>4){  //如果图片大于4张，跳出循环
                    break;
                }
            }
        }
        //更新商品信息
        $array = [];
        $params = input("param.");
        $proModel = new ProductModel();
        $proInfo = $proModel->where("pro_id",$proId)->find();   //商品信息
        $beforStock = $proInfo->pro_stock;
        
        $array['pro_name'] = $params['name'];
        $array['pro_producer'] = $params['producer'];
        $array['pro_approval_number'] = $params['approval_number'];
        $array['pro_deposit'] = $params['deposit'];
        $array['pro_specification'] = $params['specification'];
        $array['pro_effect'] = $params['effect'];
        $array['pro_taboo'] = $params['taboo'];
        $array['pro_after_sale_description'] = $params['after_sale'];
        if (isset($params['add_stock'])){
            if (!is_numeric($params['add_stock']) || !is_int($params['add_stock']+0)){
                $params['add_stock'] = 0;
            }
            $array['pro_stock'] = $beforStock + $params['add_stock'];
        }
        if (isset($params['del_stock'])){
            if (!is_numeric($params['del_stock']) || !is_int($params['del_stock']+0)){
                $params['del_stock'] = 0;
            }
            if (($beforStock - $params['del_stock'])<0){
                $array['pro_stock'] = 0;
            }else{
                $array['pro_stock'] = $beforStock - $params['del_stock'];
            }
        }
        $array['pro_price'] = $params['price'];
        $array['pro_postage'] = $params['freight'];
        $array['pro_is_hot'] = $params['is_hot'];
        $array['pro_is_onsale'] = $params['is_onsale'];
        $array['pro_is_recommend'] = $params['is_recommend'];
        $array['dosage_id'] = $params['dosage'];
        $array['category_id'] = $params['category'];
        $array['pro_brand'] = $params['brand'];
        $array['main_img_id'] = $params['topic_img'];
        $proModel->save($array,['pro_id'=>$proId]);
        
        $this->success("更新成功","Product/editProduct?pro_id={$proId}");
        
    }
    
    
    
    
    
    
    
    
    
}