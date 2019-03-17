<?php
namespace app\api\model;

use think\Model;
class Business extends Model{
    protected $hidden = ['create_time','update_time'];
    
    //关联图片
    public function img(){
        return $this->belongsTo("Image","img_id","ima_id");
    }
    
    /*
     * 获取店铺信息 并分离店铺描述/r/n
     */
    public function getStore(){
        $info = self::with('img')->find();
        $arr = explode("\r\n", $info['bus_description']);
        $info['bus_description'] = $arr;
        return $info;
    }
}