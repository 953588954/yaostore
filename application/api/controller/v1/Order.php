<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\UserToken;
use app\api\model\Address;
use app\api\service\Order as OrderService;
use app\lib\exception\ParamertersException;
use app\lib\exception\OrderException;
use app\api\validate\Theme;
use app\api\validate\ProductId;

class Order extends BaseController{
    
    /*
     * 下单
     * POST
     * @param array oProducts=[['id'=>1,'count'=>3],...] 商品id 商品数量
     * @param int addressId  收货地址id
     */
    public function placeOrder(){
        $oProducts = input('post.oProducts/a');
        //var_dump($oProducts);
        if (empty($oProducts)){
            throw new ParamertersException(['msg'=>'下单参数不能为空']);
        }
        foreach ($oProducts as $val){
            if (!isset($val['id']) || !isset($val['count'])){
                throw new ParamertersException(['msg'=>'下单参数有误']);
            }
            if (!is_numeric($val['id']) || ($val['id']+0)<0 || !is_int($val['id']+0)){
                throw new ParamertersException(['msg'=>'商品id必须为正整数']);
            }
            if (!is_numeric($val['count']) || ($val['count']+0)<0 || !is_int($val['count']+0)){
                throw new ParamertersException(['msg'=>'商品数量必须为正整数']);
            }
        }
        $addressId = input('post.addressId');
        if (!isset($addressId) || !is_numeric($addressId) || ($addressId+0)<0 || !is_int($addressId+0)){
            throw new ParamertersException(['msg'=>'收货地址必须存在且为正整数']);
        }
        $uid = UserToken::getTokenValue();
        //$uid = 1;
        //检查用户 和 地址 是否对应
        $addressModel = new Address();
        $addressRst = $addressModel->where(['add_id'=>$addressId,'user_id'=>$uid])->find();
        if (empty($addressRst)){
            throw new OrderException(['msg'=>'用户与地址不对应']);
        }
        $orderService = new OrderService();
        $result = $orderService->place($uid, $oProducts,$addressRst);
        
        return json([
            'order_id' => $result
        ]);
    }
    
    /*
     * 分页获取 用户的订单列表信息 默认一次获取5条
     * GET
     * @param int $page 
     * @return [[ord_id,ord_no,ord_snap_img,ord_snap_name,ord_status,ord_total_count,total_price,need_comment],[]...]
     * total_price 是邮费 和 商品总价格的总合
     * need_comment 是指完成的订单中，是否所有订单都已评论，都评论则为0，如果有商品未评论，则是1
     */
    public function getOrderList(){
        (new Theme())->goCheck();   //检测page参数
        $pages = input('get.page');
        $uid = UserToken::getTokenValue();
        
        $orderService = new OrderService();
        $rst = $orderService->myOrders($uid, $pages);
        
        return json($rst);
    }
    
    /**
     * 用户取消 待付款订单
     * GET
     * @param int id 订单id 为了方便验证，使用ProductId验证器，参数设为id
     * @return [error,msg]
     */
    public function cancelOrder(){
        (new ProductId())->goCheck();
        $orderId = input('get.id');
        $uid = UserToken::getTokenValue();
        
        $orderService = new OrderService();
        $rst = $orderService->cancel($uid, $orderId);
        return json($rst);
    }
    
    /**
     * 用户删除 已取消的订单
     * GET
     * @param int id
     * @return [error,msg]
     */
    public function deleteOrder(){
        (new ProductId())->goCheck();
        $orderId = input('get.id');
        $uid = UserToken::getTokenValue();
        
        $orderService = new OrderService();
        $rst = $orderService->delete($uid, $orderId);
        return json($rst);
    }
    
    /**
     * 根据订单id 获取订单详情 和 收货地址信息
     * GET
     * @param int id
     * @return [orderInfo=>[ord_no,ord_freight_price,ord_product_price,ord_status,create_time],productInfo=>[[needComment],[needComment]..],addressInfo=>[]]
     * needComment 是否需要评论 ，默认0或者没有 不需要评论，只有订单完成并且没有评论过的 则为1 
     */
    public function getOrderDetail(){
        (new ProductId())->goCheck();
        $orderId = input('get.id');
        $uid = UserToken::getTokenValue();
        $orderService = new OrderService();
        $rst = $orderService->detail($uid, $orderId);
        return json($rst);
    }
    
    /**
     * 根据订单id 获取物流信息
     * GET
     * @param int id
     * @return [status,msg,result]
     */
    public function getLogisticsInfo(){
        (new ProductId())->goCheck();
        $orderId = input('get.id');
        $uid = UserToken::getTokenValue();
        
        $orderService = new OrderService();
        $rst = $orderService->logistic($orderId);
        return json($rst);
    }
    
    /**
     * 根据订单id 确认收货
     * GET
     * @param int id
     * @return [error,msg]
     */
    public function confirmReceipt(){
        (new ProductId())->goCheck();
        $orderId = input('get.id');
        $uid = UserToken::getTokenValue();
        
        $orderService = new OrderService();
        $rst = $orderService->confirm($uid, $orderId);
        return json($rst);
    }
    
    /**
     * 申请退款
     * POST
     * @param int id
     * @param string content  退款理由
     * @return [error,msg]
     */
    public function refundOrder(){
        (new ProductId())->goCheck();
        $orderId = input('post.id');
        $content = input('post.content');
        $uid = UserToken::getTokenValue();
        
        $orderService = new OrderService();
        $rst = $orderService->refund($uid, $orderId,$content);
        return json($rst);
    }
    

    
    
}