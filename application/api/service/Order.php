<?php
/*
 * 订单服务层
 */
namespace app\api\service;

use app\api\model\Product;
use app\lib\exception\ProductException;
use app\api\model\Address;
use app\lib\exception\OrderException;
use think\Db;
use think\Exception;
use app\api\model\Order as OrderModal;
use app\api\model\OrderProduct;
use app\lib\enum\OrderStatus;
use app\lib\exception\ParamertersException;
use app\lib\exception\LogicticsException;
use think\Loader;
use app\lib\exception\PayException;

Loader::import("WxPay.WxPay",EXTEND_PATH,".Api.php");
class Order{
    private $uid;   //用户id
    private $oProducts; //下单的参数 oProducts=[['id'=>1,'count'=>3],...]
    private $products;  //实际下单的商品信息
    
    public function __construct(){
    }
    
    /*
     * 下订单
     * @param int $uid 用户id
     * @param array $oProducts [['id','count'],[]...] 
     * @param array $addressRst ['add_id','add_name'...]
     * return int 订单id
     */
    public function place($uid,$oProducts,$addressRst){
        //地区检测 是否配送
        //取出所有下单商品的简要信息
        //检测库存      不同过->抛出异常
        //通过->保存数据库 order order_product 
        //返回订单id
        $this->uid = $uid;
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsInfo($oProducts);
        
        $checkPostageRst = Address::getPostageByAddressInfo($oProducts, $addressRst);   //检测是否配送，返回notPass、postagePrice邮费
        if ($checkPostageRst['notPass']==1){
            throw new OrderException(['msg'=>'该地区暂不配送']);
        }
        
        $checkStockRst =  $this->checkPros();   //检测库存
        
        $result = $this->newOrderInDB($checkStockRst,$addressRst,$checkPostageRst['postagePrice']);
        return $result;
    }
    
    /*********生成订单 存入数据库*********/
    private function newOrderInDB($orderInfo,$addressInfo,$postagePrice){
        Db::startTrans();
        try{
            //订单新增
            $ordModal = new OrderModal();
            $ordModal->ord_no = $this->makeOrderNo();   //订单号
            $ordModal->ord_freight_price = $postagePrice;   //邮费
            $ordModal->ord_product_price = $orderInfo['price_count'];   //商品总价格
            if (count($orderInfo['productsArr'])>1){    //快照商品名
                $ordModal->ord_snap_name = $orderInfo['productsArr'][0]['pro_name']."等";
            }else{
                $ordModal->ord_snap_name = $orderInfo['productsArr'][0]['pro_name'];
            }
            $ordModal->ord_snap_img = $orderInfo['productsArr'][0]['ima_url'];  //快照头图
            $ordModal->ord_total_count = $orderInfo['total_count']; //商品总数量
            $ordModal->ord_snap_items = json_encode($orderInfo['productsArr']); //所有商品简要信息快照 json
            $ordModal->ord_snap_address = json_encode($addressInfo);    //收货地址快照 json
            $ordModal->ord_status = OrderStatus::NO_PAY;  //订单状态  待支付状态
            $ordModal->user_id = $this->uid;    //下单用户id
            $ordModal->save();
            
            $orderId = $ordModal->ord_id;   //得到订单id
            
            //订单_商品表新增
            $ord_proModal = new OrderProduct();
            $dataArr = [];
            foreach ($this->oProducts as $k=>$v){
                $dataArr[$k]['order_id'] = $orderId;
                $dataArr[$k]['product_id'] = $v['id'];
                $dataArr[$k]['count'] = $v['count'];
                $dataArr[$k]['is_comment'] = 0;
            }
            $ord_proModal->saveAll($dataArr);
            
            Db::commit();
            return $orderId;
            
        }catch (Exception $e){
            Db::rollback();
            throw $e;
        }
    }
    
    /********检测库存**********/
    private function checkPros(){
        $checkRst = [
            'price_count' => 0, //订单总价格
            'total_count' => 0, //订单商品总数量
            'pass' => true,     //订单库存是否通过
            'productsArr' => [] //所有商品简要信息 存放数组  二维
        ];
        
        foreach ($this->oProducts as $oProduct){
            $sigleInfo = $this->checkSiglePro($oProduct['id'], $oProduct['count'], $this->products);
            
            $checkRst['price_count'] += $sigleInfo['price']*$sigleInfo['count'];
            $checkRst['total_count'] += $sigleInfo['count'];
            array_push($checkRst['productsArr'], $sigleInfo['productItem']);
        }
        
        return $checkRst;
    }
    
    /********对每一个商品检测********/
    private function checkSiglePro($pro_id,$count,$products){
        $sigleInfo = [
            'price' => 0,   //单个价格
            'count' => 0,   //下单此商品数量
            'haveStock' => true,    //此商品库存是否通过
            'productItem' => [] //单个商品的简要信息  一维
        ];
        $index = -1;
        $lenth = count($products);
        for ($i=0;$i<$lenth;$i++){
            if ($products[$i]['pro_id']==$pro_id){
                $index = $i;
            }
        }
        if ($index==-1){
            throw new OrderException(['msg'=>'id为'.$pro_id.'的商品已下架或不存在，请重新选择商品下单']);
        }
        
        $thisInfo = $products[$index];
        if (($thisInfo['pro_stock']-$count)<0){
            throw new OrderException(['msg'=>'商品’'.$thisInfo['pro_name'].'‘的库存量不足']);
        }
        $thisInfo['counts'] = $count;
        
        $sigleInfo['price'] = $thisInfo['pro_price'];
        $sigleInfo['count'] = $count;
        $sigleInfo['productItem'] = $thisInfo;
        
        return $sigleInfo;
    }
    
    /*****获取下单商品简要信息******/
    private function getProductsInfo($oProduts){
        $idArr = []; //商品id数组
        foreach ($oProduts as $val){
            array_push($idArr, $val['id']);
        }
        $proInfo = Product::all(function($query) use($idArr){
            $query->where('pro_id','in',$idArr)->where('pro_is_onsale',1)->join('image img','product.main_img_id=img.ima_id','LEFT');
        });
        //var_dump($proInfo);
        if (empty($proInfo)){
            throw new ProductException(['msg'=>'没有查到相关商品信息']);
        }
        $proInfo = collection($proInfo)->visible(['pro_id','pro_name','pro_price','pro_stock','ima_url'])->toArray();
        foreach ($proInfo as &$value){
            $url = str_replace("\\", "/", $value['ima_url']);
            $value['ima_url'] = config('queue.basic_url').'uploads/'.$url;
        }
        return $proInfo;
    }
    
    /*****生成订单号******/
    private function makeOrderNo(){
        $char = ['A','B','C','D','E','F','G','H','I','J','K','L'];
    
        $year = $char[(date('Y')-2018)%10];
        $mouth = $char[date('n')-1];
        $day = date('d');
        $second = substr(time(),-5);
        $sub_str = sprintf('%02d',mt_rand(0,99));
    
        $orderNo = $year.$mouth.$day.$second.$sub_str;
        return $orderNo;
    }
    
    
    /**
     * 根据page参数分页获取该用户订单列表
     */
    public function myOrders($uid,$pages,$count=5){
        $orderList = OrderModal::where('user_id',$uid)->order('create_time desc')->limit(($pages-1)*$count,$count)->select();
        
        $result = [];
        foreach ($orderList as $key=>$val){
            $result[$key]['ord_id'] = $val['ord_id'];
            $result[$key]['ord_no'] = $val['ord_no'];
            $result[$key]['ord_snap_img'] = getOrderImgUrl($val['ord_snap_img']);
            $result[$key]['ord_snap_name'] = $val['ord_snap_name'];
            $result[$key]['ord_status'] = $val['ord_status'];
            $result[$key]['ord_total_count'] = $val['ord_total_count'];
            $total_price = $val['ord_freight_price'] + $val['ord_product_price'];
            $result[$key]['total_price'] = round($total_price,2);
            if ($val['ord_status']==OrderStatus::FINISHED){
                $result[$key]['need_comment'] = $this->checkProductIsComment($val['ord_id'],json_decode($val['ord_snap_items'],true));
            }
        }
        return $result;
    }
    /******循环订单 里的商品  检测是否都已评论*******/
    private function checkProductIsComment($ordId,$orderList){
        $isCommend = 0; //是否需要显示去评论
        $orderProductModal = new OrderProduct();
        foreach ($orderList as $val){
            $oneData = $orderProductModal->where('order_id',$ordId)->where('product_id',$val['pro_id'])->find();
            if ($oneData['is_comment']==0){
                $isCommend = 1;
            }
        }
        return $isCommend;
    }
    
    /**
     * 根据订单id 取消 未支付的订单
     */
    public function cancel($uid, $orderId){
        //判断用户和该订单是否对应
        //判断此订单状态是否为支付状态
        $rst = self::userAndOrderIsCorresponding($uid, $orderId);
        if ($rst['ord_status']!=0){
            throw new ParamertersException(['msg'=>'出错了，不是待支付订单不能取消']);
        }  
        $orderModal = new OrderModal();
        $orderModal->save(['ord_status'=>OrderStatus::CANCEL],['ord_id'=>$orderId]);
        
        return ['error'=>0,'msg'=>'取消订单成功'];
    }
    
    /**
     * 根据订单id 删除 已取消的订单
     */
    public function delete($uid, $orderId){
        $rst = self::userAndOrderIsCorresponding($uid, $orderId);
        if ($rst['ord_status']!=6){
            throw new ParamertersException(['msg'=>'出错了，不是已取消的订单不能删除']);
        }
        $orderModal = new OrderModal();
        $orderModal->where('ord_id',$orderId)->delete();
        return ['error'=>0,'msg'=>'订单删除成功'];
    }
    
    /**
     * 获取订单详情
     */
    public function detail($uid, $orderId){
        $rst = self::userAndOrderIsCorresponding($uid, $orderId);
        $result = [];
        $result['orderInfo']['ord_no'] = $rst['ord_no']; //订单号
        $result['orderInfo']['ord_freight_price'] = $rst['ord_freight_price'];   //邮费
        $result['orderInfo']['ord_product_price'] = $rst['ord_product_price'];   //商品总价格
        $result['orderInfo']['ord_status'] = $rst['ord_status']; //订单状态
        $result['orderInfo']['create_time'] = $rst['create_time'];   //订单创建时间
        if ($rst['ord_status']!=OrderStatus::FINISHED){
            $result['productInfo'] = json_decode($rst['ord_snap_items'],true);  //所有商品信息  二维数组
        }else{  //如果订单是完成状态，则需要去检查 是否需要评论
            $result['productInfo'] = $this->needComment($orderId, json_decode($rst['ord_snap_items'],true));
        }
        
        $result['addressInfo'] = json_decode($rst['ord_snap_address'],true);    //收货地址信息  一维
        return $result;
    }
    /*****循环出来订单中所有商品，检查是否需要评论*****/
    private function needComment($orderId,$productList){
        $orderProductModal = new OrderProduct();
        foreach ($productList as &$item){
            $oneData = $orderProductModal->where(['order_id'=>$orderId,'product_id'=>$item['pro_id']])->find();
            if ($oneData['is_comment']==0){
                $item['needComment'] = 1;
            }else{
                $item['needComment'] = 0;
            }
        }
        return $productList;
    }
    
    /**
     * 订单确认收货
     */
    public function confirm($uid,$orderId){
        $rst = self::userAndOrderIsCorresponding($uid, $orderId);
        if($rst['ord_status']!=OrderStatus::SHIPPED){
            throw new OrderException(['msg'=>'非已发货状态订单不能确认收货']);
        }
        $orderModal = new OrderModal();
        $orderModal->save(['ord_status'=>OrderStatus::FINISHED],['ord_id'=>$orderId]);
        return [
            'error' => 0,
            'msg' => '确认收货成功'
        ];
    }
    
    /**
     * 订单退款申请
     */
    public function refund($uid,$orderId,$content=''){
        $rst = self::userAndOrderIsCorresponding($uid, $orderId);
        if ($rst['ord_status']!=OrderStatus::PAID){
            throw new OrderException(['msg'=>'非待发货状态订单不能申请退款']);
        }
        $orderModal = new OrderModal();
        $orderModal->save(['ord_status'=>OrderStatus::SALE_RETURN,'refund_content'=>$content],['ord_id'=>$orderId]);
        return [
            'error' => 0,
            'msg' => '订单退款中'
        ];
    }
    
    /*******判断用户和订单是否对应*********/
    public static function userAndOrderIsCorresponding($uid,$orderId){
        $rst = OrderModal::where(['ord_id'=>$orderId,'user_id'=>$uid])->find();
        if (empty($rst)){
            throw new ParamertersException(['msg'=>'用户与订单不对应']);
        }
        return $rst;
    }
    
    /**
     * 获取订单物流
     */
    public function logistic($orderId){
        $orderModal = new OrderModal();
        $orderRst = $orderModal->where('ord_id',$orderId)->find();
        if ($orderRst['ord_status']!=OrderStatus::SHIPPED && $orderRst['ord_status']!=OrderStatus::FINISHED || empty($orderRst['ord_kuaidi_no'])){
            throw new LogicticsException(['msg'=>'查看物流失败，订单未发货']);
        }
        
        $logicticsService = new Logictics($orderRst['ord_kuaidi_no'], $orderRst['ord_kuaidi_name']);
        $rst = $logicticsService->getLogictic();
        //把订单发货时间放进去
        $rst['send_good_time'] = date("Y-m-d H:i:s",$orderRst['send_good_time']);
        return $rst;
    }
    
    /**
     * 订单退款
     */
    public function priceRefund($orderInfo){
        $wxPayRefundObj = new \WxPayRefund();
        $wxPayRefundObj->SetOut_trade_no($orderInfo['ord_no']);
        $wxPayRefundObj->SetOut_refund_no($orderInfo['ord_no']);
        $totalPrice = round($orderInfo['ord_freight_price'] + $orderInfo['ord_product_price'],2);
        //var_dump($totalPrice*100);die();
        $wxPayRefundObj->SetTotal_fee($totalPrice*100);
        $wxPayRefundObj->SetRefund_fee($totalPrice*100);
        return $this->goRefund($wxPayRefundObj);
    }
    
    /**去调用接口退款*****/
    private function goRefund($refundObj){
        $wxPayApiObj = new \WxPayApi();
        $rst = $wxPayApiObj->refund($refundObj);
        if ($rst['return_code']!='SUCCESS' || $rst['result_code']!='SUCCESS'){
            $filename = "./error.txt";
            $fp = fopen($filename, 'a+');
            fwrite($fp, date("Y-m-d H:i:s",time()).":微信退款出错："."\r\n");
            foreach ($rst as $key=>$val){
                fwrite($fp, $key."=>".$val."\r\n");
            }
            fclose($fp);
            throw new PayException(['msg'=>'微信退款失败']);
        }
        $ord_no = $rst['out_trade_no'];
        $orderModal = new OrderModal();
        $orderData = $orderModal->where('ord_no',$ord_no)->find();
        if (empty($orderData)){
            $filename = "./error.txt";
            $fp = fopen($filename, 'a+');
            fwrite($fp, date("Y-m-d H:i:s",time()).":微信退款成功，单返回结果没有查到该订单。"."\r\n");
            fclose($fp);
            throw new PayException(['msg'=>'微信退款成功，单返回结果没有查到该订单']);
        }
        if ($orderData['ord_status']!=OrderStatus::SALE_RETURN){
            $filename = "./error.txt";
            $fp = fopen($filename, 'a+');
            fwrite($fp, date("Y-m-d H:i:s",time()).":微信退款成功，单该订单并不是退款状态。"."\r\n");
            fclose($fp);
            throw new PayException(['msg'=>'微信退款成功，单该订单并不是退款状态']);
        }
        $orderModal->save(['ord_status'=>OrderStatus::RETURN_FINNISHED],['ord_no'=>$ord_no]);
        return true;
    }
    

    
}