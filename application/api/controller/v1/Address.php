<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\lib\exception\ParamertersException;
use app\api\service\Token;
use app\api\model\Address as AddressModel;
use app\api\validate\AddressId;
use app\lib\exception\AddressException;
class Address extends BaseController{
    
    /*
     * 根据传过来商品数组 ，获取该用户 地址信息、邮费、是否配送 返回
     * 若没有地址信息，则返回 邮费0 地址空字符串
     * POST
     * @param productsArr [[id,...][id,...]]商品数组    
     * @param addressId 地址id 初始为0
     * return ['addressInfo','postagePrice','notPass']
     */
    public function getAddressAndPostage(){
        $proArr = input('post.productsArr/a');
        foreach ($proArr as $pro){
            if (!isset($pro['id'])){
                throw new ParamertersException(['msg'=>'缺少商品id参数']);
            }
        }
        $addressId = input('post.addressId');
        if (!is_numeric($addressId)){
            throw new ParamertersException(['msg'=>'地址参数必须是数字']);
        }
        
        $uid = Token::getTokenValue();  //获取此用户id
        $addressModel = new AddressModel();
        if ($addressId==0){
            $addressInfo = $addressModel->where('user_id',$uid)->where('add_default',1)->find();
        }else{
            $addressInfo = $addressModel->where('add_id',$addressId)->find();
        }
        
        if (!$addressInfo){
            return json([
                'addressInfo' => '',
                'postagePrice' => 0,
                'notPass' => 0
            ]);
        }else{
            $rst = $addressModel::getPostageByAddressInfo($proArr, $addressInfo);
            return json([
                'addressInfo' => $addressInfo,
                'postagePrice' => $rst['postagePrice'],
                'notPass' => $rst['notPass']
            ]);
        }
    }
    
    /*
     * 添加地址信息
     * POST
     * @param addressInfo [userName,telNumber,provinceName,cityName,countyName,detailInfo]
     */
    public function addAddress(){
        $addressInfo = input('post.addressInfo/a');
        if(empty($addressInfo)){
            throw new ParamertersException(['msg'=>'请传入addressInfo参数']);
        }
        if (!isset($addressInfo['userName']) || !isset($addressInfo['telNumber']) ||!isset($addressInfo['provinceName']) ||!isset($addressInfo['cityName']) ||!isset($addressInfo['countyName']) ||!isset($addressInfo['detailInfo'])){
            throw new ParamertersException(['msg'=>'地址参数有误']);
        }
        $uid = Token::getTokenValue();  //获取此用户id
        
        $addModel = new AddressModel();
        //先查询此用户是否有地址信息，
        //如有地址信息 则 默认add_default 为0，如果是第一次添加，则add_default 为1
        $addRst = $addModel->where("user_id",$uid)->select();
        if (!$addRst){
            $addModel->add_default = 1;
        }
        $addModel->add_name = $addressInfo['userName'];
        $addModel->add_phone = $addressInfo['telNumber'];
        $addModel->add_province = $addressInfo['provinceName'];
        $addModel->add_city = $addressInfo['cityName'];
        $addModel->add_country = $addressInfo['countyName'];
        $addModel->add_detail = $addressInfo['detailInfo'];
        $addModel->user_id = $uid;
        $addModel->save();
        return json([
            'error' => 0,
            'msg' => '添加成功'
        ]);
    }
    
    /*
     * 获取用户所有地址信息
     * GET
     */
    public function getAllAddress(){
        $uid = Token::getTokenValue();  //获取此用户id
        $addModel = new AddressModel();
        $addInfo = $addModel->where("user_id",$uid)->select();
        return json([
            'addressInfo'=>$addInfo
        ]);
    }
    
    /*
     * 删除地址信息
     * GET
     * @param id 地址信息id
     */
    public function delAddressById(){
        (new AddressId())->goCheck();
        $id = input('get.id');
        $uid = Token::getTokenValue();  //获取此用户id
        
        $addModel = new AddressModel();
        $addInfo = $addModel->where("add_id",$id)->find();
        if (!$addInfo){
            throw new ParamertersException(['msg'=>'没有查到地址信息']);
        }
        //检测用户id 与 地址id 是否匹配 
        if ($addInfo['user_id']!=$uid){
            throw new AddressException(['msg'=>'用户id与地址id不匹配，无法操作']);
        }
        $addModel->where("add_id",$id)->delete();
        return json([
            'error'=>0,
            'msg' => '删除成功'
        ]);
    }
    
    /*
     * 设置默认地址
     * GET
     * @param id 地址id
     */
    public function setDefaultAddress(){
        (new AddressId())->goCheck();
        $id = input('get.id');
        $uid = Token::getTokenValue();  //获取此用户id
        
        $addModel = new AddressModel();
        $addInfo = $addModel->where("user_id",$uid)->select();
        //循环更改 地址信息 add_default 0
        $arrWhere = [];
        foreach ($addInfo as $val){
            $arr = ['add_id'=>$val['add_id'],'add_default'=>0];
            //$addModel->save(['add_default'=>0],['add_id'=>$val['add_id']]);
            array_push($arrWhere, $arr);
        }
        $addModel->saveAll($arrWhere);
        //更改默认地址
        $addModel->save(['add_default'=>1],['add_id'=>$id]);
        return json([
            'error'=>0,
            'msg' => '设置成功'
        ]);
    }
    
    
    
}