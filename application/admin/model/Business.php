<?php
namespace app\admin\model;

use think\Model;
use app\admin\controller\BaseController;
class Business extends Model{
    protected $autoWriteTimestamp = true;
    
    /*
     * 访问腾讯地图api 获取地址坐标
     * @param string $addr 物理地址
     * @return array
     */
    public function getAddressInfo($addr){
        $url = sprintf(config("queue.map_url"),$addr,config("queue.map_key"));
        $rst = curl_get($url);
        $rst = json_decode($rst,true);
        if ($rst['status']!=0){
            $baseController = new BaseController();
            $baseController->toError("地址有误：".$rst['message'], "Index/storeInfo");
        }
        return $rst;
    }
    
    /*
     * 获取所有店铺信息
     */
    public function getStoreInfo(){
        $storeInfo = self::with('img')->select();
        //对所有店铺描述 \r\n转换
        foreach ($storeInfo as &$val){
            $val['bus_description'] = str_replace("\r\n", "<br/>", $val['bus_description']);
        }
        return $storeInfo;
    }
    
    //店铺与image表关联
    public function img(){
        return $this->belongsTo("Image","img_id","ima_id");
    }
    
    /*
     * 删除店铺
     */
    public function deleteById($id){
        $storeInfo = self::get($id);
        $ima_id = $storeInfo['img_id'];
        //删除图片
        $imgModel = new Image();
        $imgUrl = $imgModel->get($ima_id);
        $url = $imgUrl->getData('ima_url');
        $url = str_replace("\\", "/", $url);
        unlink(ROOT_PATH."/public/uploads/".$url);
        $imgModel->destroy($ima_id);
       // Db::table('image')->where("ima_id",$ima_id)->delete();
        //删除店铺信息
        self::destroy($id);
        //Db::table('business')->where("bus_id",$id)->delete();
    }
    
    
    
    
}