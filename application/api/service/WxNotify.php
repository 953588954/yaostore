<?php
namespace app\api\service;

use think\Loader;
use think\Db;
use app\api\model\Order;
use think\Log;
use app\api\model\OrderProduct;
use app\api\model\Product;
use think\Exception;
use app\lib\enum\OrderStatus;

Loader::import("WxPay.WxPay",EXTEND_PATH,".Api.php");

class WxNotify extends \WxPayNotify{
    /*
     * 重新回调方法，处理业务
     */
    public function NotifyProcess($data, &$msg){
        if ($data['result_code']=="SUCCESS"){
            $order_no = $data['out_trade_no'];
            //减少库存量
            //改变订单状态为 已支付（待发货）状态
            Db::startTrans();
            try{
                $orderModal = new Order();
                $orderInfo = $orderModal->where('ord_no',$order_no)->lock(true)->find();
                if($orderInfo['ord_status']==0){
                    $orderModal->save(['ord_status'=>OrderStatus::PAID,'time_end'=>$data['time_end']],['ord_no'=>$order_no]);
                    $this->changeProductStock($orderInfo['ord_id']);
                }
                Db::commit();
            }catch(Exception $e){
                $filename = "./error.txt";
                $fp = fopen($filename, 'a+');
                //foreach ($data as $key=>$val){
                    fwrite($fp, $e->getMessage()."\r\n");
                //}
                fclose($fp);
                
                Db::rollback();
                return false;
            }
        }
        return true;
    }
    
    /********改变商品库存********/
    private function changeProductStock($order_id){
        $productArr = OrderProduct::where("order_id",$order_id)->select();
        foreach ($productArr as $singleProduct){
            Product::where('pro_id',$singleProduct['product_id'])->setDec('pro_stock',$singleProduct['count']);
        }
    }
}