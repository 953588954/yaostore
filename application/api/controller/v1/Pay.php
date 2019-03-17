<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\lib\exception\PayException;
use app\api\model\Order as OrderModal;
use app\api\service\Pay as PayService;
use app\api\service\WxNotify;
use app\api\service\Token;

class Pay extends BaseController{
    /*
     * 微信支付
     * GET
     * @param int order_id 订单id
     * @param int needCheckPrice [0|1] 是否需要重新检测订单商品的价格和邮费
     * @return array paySign 一维数组   小程序吊起支付的签名
     */
    public function pay(){
        $orderId = input('get.order_id');
        if (!is_null(input('get.needCheckPrice')) && input('get.needCheckPrice')==1){
            $needCheckPrice = 1;
        }else{
            $needCheckPrice = 0;
        }
        //检测订单id 正整数
        //检测是否有此订单
        if (!is_numeric($orderId) || ($orderId+0)<0 || !is_int($orderId+0)){
            throw new PayException(['msg'=>'订单id必须为正整数']);
        }
        $orderModal = new OrderModal();
        $orderInfo = $orderModal->where('ord_id',$orderId)->find();
        if (empty($orderInfo)){
            throw new PayException(['msg'=>'没有查到此订单信息']);
        }
        $uid = Token::getTokenValue();  //获取此用户id
        $payService = new PayService($uid, $orderId);
        $paySign = $payService->getPaySign($orderInfo,$needCheckPrice);
        
         return json(['paySign'=>$paySign]);
    }
    
    /*
     * 微信支付后 的函数 回调
     */
    public function receiveNotify(){
        $notify = new WxNotify();
        $notify->Handle();
    }
    
    
    
    
}