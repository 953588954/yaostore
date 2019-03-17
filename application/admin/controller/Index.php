<?php
namespace app\admin\controller;


use app\admin\validate\AddStore;
use app\admin\model\Business;
use app\admin\model\Image;
use app\admin\model\Root;
use app\admin\model\BannerItem;
use app\admin\model\Theme;
use app\admin\model\Category;
use app\admin\model\Product;
class Index extends BaseController{
    
    /*
     * 个人信息
     */
    public function index(){
        
        $this->assign('navigation1','基本设置');
        $this->assign('navigation2','个人信息');
        return view('index');
    }
    
    /*
     * 修改密码
     */
    public function editPwd(){
        $params = input("post.");
        $rootModel = new Root();
        $rootModel->checkPwd($params);  //修改
        session(null);
        $this->success("修改成功","Login/login");
    }
    
    /*
     * 门店信息
     */
    public function storeInfo(){
//         echo ROOT_PATH;die;
        $businessModel = new Business();
        $storeInfo = $businessModel->getStoreInfo();
       // var_dump($storeInfo[0]['img']['ima_url']);die;        
        $this->assign("empty","<h1 style='text-align:center'>暂无店铺，请添加</h1>");
        $this->assign('storeInfo',$storeInfo);
        $this->assign('navigation1','基本设置');
        $this->assign('navigation2','门店信息');
        return view('storeInfo');
    }
    
    /*
     * 删除店铺
     */
    public function deleteStore(){
       
        $id = input("param.id");
        //echo $id;die;
        $businessModel = new Business();
        $businessModel->deleteById($id);
        $this->success("删除成功","Index/storeInfo");
    }
    
    /*
     * 添加店铺
     */
    public function addStore(){
        var_dump($_POST);
        var_dump($_FILES);die;
        (new AddStore("Index/storeInfo"))->goCheck();
        
        $postInfo = input("post.");
 
        //var_dump( explode("\r\n", $postInfo['bus_description']));die;
        //调用腾讯地图接口，吧地址变成坐标
        $businessModel = new Business();
        $addressInfo = $businessModel->getAddressInfo($postInfo['bus_address']);
        $lng = $addressInfo['result']['location']['lng'];   //经度
        $lat = $addressInfo['result']['location']['lat'];   //维度
        //上传图片，验证
        //返回图片路径
        $file = request()->file("store_img");
        $info = $file->validate([
            'size'=>1024*2*1024,
            'ext' => 'jpg,png,jpeg'
        ])->move(ROOT_PATH.'public'.DS.'uploads');
        if ($info){
            $img_url = $info->getSaveName();    //图片路径
        }
        else{
            $this->error("图片上传失败：".$file->getError(),"Index/storeInfo");exit;
        }
        //存入数据库1.存入image表 2.存入店铺表
        $imageModel = new Image();
        $imageModel->ima_url = $img_url;
        $imageModel->save();
        $img_id = $imageModel->ima_id;  //图片id
        
        $businessModel->data([
            'bus_name' => $postInfo['bus_name'],
            'phone' => $postInfo['phone'],
            'bus_address' => $postInfo['bus_address'],
            'bus_open_time' => $postInfo['bus_open_time'],
            'bus_open_day' => $postInfo['bus_open_day'],
            'bus_description' => $postInfo['bus_description'],
            'bus_lng' => $lng,
            'bus_lat' => $lat,
            'img_id' => $img_id
        ]);
        $businessModel->save();
        $this->success("添加成功","Index/storeInfo");
    }
    
    /*
     * 店铺轮播图设置
     */
    public function storeBanner(){
        //查询已有图片
        $bannerModel = new BannerItem();
        $bannerImgs = $bannerModel->getBannerInfo();
        $bannerImgs = collection($bannerImgs)->toArray();
        //所有分类
        $cateModel = new Category();
        $cateInfo = $cateModel->select();

        //var_dump($bannerImgs);die;
        $this->assign("bannerImgs",$bannerImgs);
        $this->assign("catInfo",$cateInfo);
        $this->assign('navigation1','网店设置');
        $this->assign('navigation2','轮播图设置');
        return view('storeBanner');
    }
    /*
     * 设置启用的轮播图
     */
    public function setBannerUse(){
        $bannerId = input("param.ban_id");
        $isUse = input("param.is_use");
        $bannerModel = new BannerItem();
        $rst = $bannerModel->useBannerImg($bannerId,$isUse);
        if ($rst){
            $this->success("更改成功","storeBanner");
        }else{
            $this->error("更改失败,可同时启用4~6个轮播图");
        }
    }
    /*
     * 删除轮播图
     */
    public function delBanner(){
        $bannerId = input("param.ban_id");
        $bannModel = new BannerItem();
        $rst = $bannModel->delBannerImg($bannerId);
        if ($rst){
            $this->success("删除成功","storeBanner");
        }else{
            $this->error("删除失败,正在启用的轮播图不能删除","storeBanner");
        }
    }
    /*
     * 上传轮播图
     */
    public function uploadBanners(){
        $proId = input("param.product");
        //var_dump($proId);die;
        if (is_null($proId) || !is_numeric($proId)){
            $this->error("请关联一个商品","storeBanner");die;
        }
        //图片上传
        $bannerModel = new BannerItem();
        $rst = $bannerModel->upload_banners($proId);
       if (!$rst){
           $this->error("请上传不大于2M的正确图片","storeBanner");
       }else{
           $this->success("上传成功","storeBanner");
       }
    }
    /*
     * ajax 根据分类id 获取商品
     */
    public function getProductsByCat(){
        $catId = input("param.cat_id");
        checkID($catId);
        $proModel = new Product();
        $products = $proModel->where("category_id",$catId)->select();
        if (!$products){
            echo json_encode([
                'error' => 1,
                'msg' => "该分类下没有查到商品"
            ]);exit;
        }else{
            echo json_encode([
                'error' => 0,
                'data' => $products
            ]);exit;
        }
    }
    
    /*
     * 主题设置 页
     */
    public function theme(){
        //取出所有主题
        $themeModel = new Theme();
        $themes = $themeModel->getThemes();
        
        $this->assign("themes",$themes);
        $this->assign('navigation1','网店设置');
        $this->assign('navigation2','主题设置');
        return view('theme');
    }
    /*
     * 主题图片替换
     */
    public function replaceThemeImg(){
        $themeId = input("param.the_id");   //主题id
        
        $file = request()->file('topic_img');
        if ($file){
            $info = $file->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,jpeg'])->move(ROOT_PATH.'public'.DS.'uploads');
            if ($info){
                $url = $info->getSaveName();    //图片路径
                
                $themeModel = new Theme();
                $themeInfo = $themeModel->where("the_id",$themeId)->find();//主题记录
                //var_dump($themeId);die;
                $imageModel = new Image();
                //第一次 添加 记录
//                 $imageModel->ima_url = $url;
//                 $imageModel->save();
//                 $imgId = $imageModel->ima_id;
                
                //第二次 更新记录
                $imgInfo = $imageModel->where("ima_id",$themeInfo['topic_img_id'])->find(); //图片记录
                $beforImgUrl = $imgInfo->getData('ima_url');    //修改前图片路径
                $beforImgUrl = str_replace("\\", "/", $beforImgUrl);
                unlink(ROOT_PATH."public/uploads/".$beforImgUrl);   //删除以前图片
                $imageModel->save(['ima_url'=>$url],['ima_id'=>$themeInfo['topic_img_id']]);//更新
                //更改主题记录
                //$themeModel->save(['topic_img_id'=>$imgId],['the_id'=>$themeId]);
                
                $this->success("更新成功","theme");exit;
            }else{
                $this->error("更新失败：".$file->getError(),"theme");
            }
        }else{
            $this->error("请上传图片","theme");
        }
    }
    
    
    
   
}