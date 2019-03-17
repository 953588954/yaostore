<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\Business as BusinessModel;
class Business extends BaseController{
    
    protected $beforeActionList = [
        'checkAuth' => ['only'=>'getStoreInfo']
    ];
    
    /**
     * 获取一条 门店信息
     * GET
     */
    public function getStoreInfo(){
        $businessModel = new BusinessModel();
        $storeInfo = $businessModel->getStore();
        return json(['storeInfo'=>$storeInfo]);
    }
}