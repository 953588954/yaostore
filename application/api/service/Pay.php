<?php
namespace app\api\service;

use app\api\model\Order;
use think\Loader;
use app\lib\exception\PayException;
use app\api\model\Product;

Loader::import("WxPay.WxPay",EXTEND_PATH,".Api.php");

class Pay{
    private $uid;
    private $order_id;
    
    public function __construct($uid,$order_id){
        $this->uid = $uid;
        $this->order_id = $order_id;
    }
    
    /*
     * 返回支付签名
     */
    public function getPaySign($orderInfo,$needCheckPrice){
        if ($needCheckPrice==1){
            $this->checkPrice($orderInfo);
        }
    
        $paySign = $this->setUnifiedOrderParam($orderInfo);
        return $paySign;
    }
    
    /*******检测该订单下所有商品价格是否改变********/
    private function checkPrice($orderInfo){
        $productList = json_decode($orderInfo['ord_snap_items'],true);
        $productModal = new Product();
        foreach ($productList as $product){
            $productData = $productModal->where("pro_id",$product['pro_id'])->find();
            if (empty($productData)){
                throw new PayException(['msg'=>'没有找到‘'.$product['pro_name'].'’的商品，请重新下单']);
            }
            if ($productData['pro_is_onsale']==0){
                throw new PayException(['msg'=>'商品‘'.$product['pro_name'].'’已下架，请重新选择商品下单']);
            }
            if ($productData['pro_price']!=$product['pro_price']){
                throw new PayException(['msg'=>'商品‘'.$product['pro_name'].'’价格已变，请重新下单']);
            }
        }
    }
    
    /******设置下单参数******/
    private function setUnifiedOrderParam($orderInfo){
        $inputObj = new \WxPayUnifiedOrder();
        $inputObj->SetBody("铭玺大药房");
        $inputObj->SetOut_trade_no($orderInfo['ord_no']);
        //支付价钱=商品总价格+运费
        $payPrice = $orderInfo['ord_freight_price']+$orderInfo['ord_product_price'];
        $payPrice = round($payPrice,2);
        $inputObj->SetTotal_fee($payPrice*100);
        $inputObj->SetNotify_url(config('queue.notify_url'));
        $inputObj->SetTrade_type('JSAPI');
        //获取用户openid
        $openid = Token::getTokenValue('openid');
        $inputObj->SetOpenid($openid);
        
    
        $paySign = $this->goUnifiedOrder($inputObj);
        return $paySign;
    }
    
    /******调用统一下单接口******/
    private function goUnifiedOrder($inputObj){
        $wxpayAPI = new \WxPayApi();
        $result = $wxpayAPI->unifiedOrder($inputObj);
        if ($result['return_code']!="SUCCESS" || $result['result_code']!="SUCCESS"){

            $filename = "./error.txt";
            $fp = fopen($filename, 'a+');
            foreach ($result as $key=>$val){
                fwrite($fp, $key."=>".$val."\r\n");
            }
            
            fclose($fp);
            throw new PayException(['msg'=>'微信支付预定单失败']);
        }
        $this->savePrepayId($result['prepay_id']);
    
        $paySign = $this->getSign($result['prepay_id']);
    
        return $paySign;
    
    }
    
    /********构造支付 签名*********/
    private function getSign($prepay_id){
        $JSAPI = new \WxPayJsApiPay();
        $JSAPI->SetAppid(config('queue.appid'));
        $nonceStr = md5(time().mt_rand(0,100));
        $JSAPI->SetNonceStr($nonceStr);
        $JSAPI->SetPackage("prepay_id=".$prepay_id);
        $JSAPI->SetSignType('MD5');
        $JSAPI->SetTimeStamp((string)time());
        $sign = $JSAPI->MakeSign();
        $paySign = $JSAPI->GetValues();
        $paySign['paySign'] = $sign;
        unset($paySign['appId']);
    
        return $paySign;
    
    }
    
    /******保存prepay_id******/
    private function savePrepayId($prepay_id){
        $orderModal = new Order();
        $orderModal->save(['ord_prepay_id'=>$prepay_id],['ord_id'=>$this->order_id]);
    }
    
    
}