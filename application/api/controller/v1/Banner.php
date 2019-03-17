<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\BannerItem;
use app\lib\exception\BannerException;
class Banner extends BaseController{
    protected $beforeActionList = [
        'checkAuth' => ['only'=>'getBannerItems']
    ];
    
    /*
     * 获取banner轮播图
     */
    public function getBannerItems(){
        $bannerModel = new BannerItem();
        $rst = $bannerModel->getBannerItems();
        if (!$rst){
            throw new BannerException();
        }
        return json($rst);
    }
}