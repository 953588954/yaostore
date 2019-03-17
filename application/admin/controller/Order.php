<?php
namespace app\admin\controller;

use app\admin\model\Order as OrderModal;
use app\lib\enum\OrderStatus;
use app\admin\validate\IDMustBeInt;
use app\admin\model\User;
use app\api\service\SendTemplate;
use app\admin\model\Freight;
use app\api\service\Logictics;
use app\api\service\Order as OrderService;

class Order extends BaseController{
    /*
     * 显示订单列表
     */
    public function allOrders(){
        //整合条件
        $where = [];
        $param = [
            'ord_no' => '',
            'starTime' =>'',
            'endTime' => '',
            'ord_status' => 'all_orders'
        ];
        if (!empty(input('get.orderNo'))){
            $where['ord_no'] = ['=',input('get.orderNo')];
            $param['ord_no'] = $where['ord_no'];
        }
        if (!empty(input('get.orderStartTime')) && !empty(input('get.orderEndTime'))){
            $starTime = strtotime(input('get.orderStartTime'));
            $endTime = strtotime(input('get.orderEndTime'))+24*3600;
            $where['create_time'] = ['between',"$starTime,$endTime"];
            $param['starTime'] = input('get.orderStartTime');
            $param['endTime'] = input('get.orderEndTime');
        }
        if (!empty(input('get.orderStatus'))){
            $status = input('get.orderStatus');
            if ($status=='no_pay'){
                $where['ord_status'] = ['=',OrderStatus::NO_PAY];
            }elseif ($status=='no_shipped'){
                $where['ord_status'] = ['=',OrderStatus::PAID];
            }
            elseif ($status=='shipped'){
                $where['ord_status'] = ['=',OrderStatus::SHIPPED];
            }
            elseif ($status=='finished'){
                $where['ord_status'] = ['=',OrderStatus::FINISHED];
            }
            elseif ($status=='sale_return'){
                $where['ord_status'] = ['=',OrderStatus::SALE_RETURN];
            }
            elseif ($status=='refund_finished'){
                $where['ord_status'] = ['=',OrderStatus::RETURN_FINNISHED];
            }
            $param['ord_status'] = $status;
        }
        
        $orderModal = new OrderModal();
        $orderInfo = $orderModal->where($where)->where('ord_status','<>',OrderStatus::CANCEL)->order('create_time desc')->paginate(10);
        $page = $orderInfo->render();
        //var_dump($param);
        $this->assign('page',$page);
        $this->assign('param',$param);
        $this->assign("orderInfo",$orderInfo);
        $this->assign('navigation1','订单管理');
        $this->assign('navigation2','所有订单');
        return view('allOrders');
    }
    
    /*
     * 查看订单详情
     */
    public function orderDetail(){
        
        (new IDMustBeInt('Order/allOrders'))->goCheck();
        $logisticsInfo = config('queue.logistics_info');    //物流公司名称 与 别名
        //var_dump($logisticsInfo);die; 
        $orderInfo = OrderModal::where('ord_id',input('param.id'))->find();
        //var_dump($orderInfo);die;
        if (empty($orderInfo)){
           $this->error('没有查到相关订单信息','Order/allOrders');exit();
        }
        $orderInfo['ord_snap_items'] = json_decode($orderInfo['ord_snap_items'],true);  //二维
        $orderInfo['ord_snap_address'] = json_decode($orderInfo['ord_snap_address'],true);  //一维
        if (!empty($orderInfo['ord_kuaidi_no'])){
            //#TODO 查询物流信息
            $LogisticsService = new Logictics($orderInfo['ord_kuaidi_no'], $orderInfo['ord_kuaidi_name']);
            $orderInfo['logistics'] = $LogisticsService->getLogictic();
        }else{
            $orderInfo['logistics'] = '';
        }
        //如果有支付时间，转换格式
        if(!empty($orderInfo['time_end'])){
            $orderInfo['time_end'] = substr($orderInfo['time_end'], 0,4)."-".substr($orderInfo['time_end'], 4,2)."-".substr($orderInfo['time_end'], 6,2)." ".substr($orderInfo['time_end'], 8,2).":".substr($orderInfo['time_end'], 10,2).":".substr($orderInfo['time_end'], 12);            
        }
        
        //若果该订单 是发货状态 并且 大于了 多少天，给一个标识  在后台显示确认收货
        $orderInfo['show_finish'] = 0;
        $orderInfo['show_finish_day'] = config('queue.order_shipped_days');
        if ($orderInfo['ord_status']==OrderStatus::SHIPPED && ($orderInfo['send_good_time']+config('queue.order_shipped_days')*3600*24)<time()){
            $orderInfo['show_finish'] = 1;
        }
        //发货时间转换放到 后面 上面要用到
        if(!empty($orderInfo['send_good_time'])){
            $orderInfo['send_good_time'] = date("Y-m-d H:i:s",$orderInfo['send_good_time']);
        }
        
        $this->assign("logisticsInfo",$logisticsInfo);
        $this->assign('orderInfo',$orderInfo);
        $this->assign('navigation1','订单管理');
        $this->assign('navigation2','订单详情');
        return view('orderDetail');
    }
    
    /**
     * 修改收货地址
     * POST
     */
    public function editOrderAddress(){
        $ordId = input('param.ord_id');
        $shou_jian_ren = input('param.shou_jian_ren');
        $lian_xi_fang_shi = input('param.lian_xi_fang_shi');
        $xiang_xi_di_zhi = input('param.xiang_xi_di_zhi');
        
        if (empty($shou_jian_ren) || empty($lian_xi_fang_shi) || empty($xiang_xi_di_zhi)){
            $this->error('所有内容必填','Order/orderDetail?id='.$ordId);exit;
        }
        $orderModal = new OrderModal();
        $orderData = $orderModal->where("ord_id",$ordId)->find();
        if (empty($orderData)){
            $this->error('没有找到此订单','Order/orderDetail?id='.$ordId);exit;
        }
        //判断有没有 province 参数值，如果不为空，则说明修改了省市区，则int  province,int city都不能为空 string country可以为空
        //如果为空，则使用之前的省市区
        if (empty(input('param.province'))){
            echo '为空';
        }else{
            $province = input('param.province');
            $city = input('param.city');
            $country = input('param.country');
            if (empty($city)){
                $this->error('请选择市区','Order/orderDetail?id='.$ordId);exit;
            }
            $freightModal = new Freight();
            $data1 = $freightModal->where('fre_id',$province)->find();  //省份记录
            $data2 = $freightModal->where('fre_id',$city)->find();  //市 或 区记录
            if(in_array($data1['fre_region'], ['北京市','天津市','上海市','重庆市'])){
                $province = $data1['fre_region'];
                $city = $data1['fre_region'];
                $country = $data2['fre_region'];
            }else{
                if (empty($country)){
                    $this->error('请填写区/县/镇','Order/orderDetail?id='.$ordId);exit;
                }
                $province = $data1['fre_region'];
                $city = $data2['fre_region'];
//                 $country = $country;
            }
        }
        //修改数据库
        $addressArr = [
            'add_id' => input('param.add_id'),
            'add_name' => $shou_jian_ren,
            'add_phone' => $lian_xi_fang_shi,
            'add_province' => $province,
            'add_city' => $city,
            'add_country' => $country,
            'add_detail' => $xiang_xi_di_zhi,
            'user_id' => input('param.user_id'),
            'add_default' => input('param.add_default')
        ];
        $addressJson = json_encode($addressArr);
        $orderModal->save(['ord_snap_address'=>$addressJson],['ord_id'=>$ordId]);
        $this->success('修改成功','Order/orderDetail?id='.$ordId);
        
    }
    
    /**
     * 订单发货
     * POST
     * @param int ord_id
     * @param string ord_kuaidi_name
     * @param string ord_kuaidi_no 
     */
    public function sendGoods(){
        $ordId = input('param.ord_id');
        $kuaidiName = input('param.ord_kuaidi_name');
        $kuaidiNo = input('param.ord_kuaidi_no');
        $orderModal = new OrderModal();
        $orderData = $orderModal->where("ord_id",$ordId)->find();
        if (empty($orderData)){
            $this->error('没有找到此订单','Order/orderDetail?id='.$ordId);exit;
        } 
        //发送模板消息
        $userData = User::where('use_id',$orderData['user_id'])->find();
        $form_id = $orderData['ord_prepay_id'];
        $touser = $userData['use_openid'];
        $sendTemplate = new SendTemplate($touser, $form_id);
        $sendTemplate->send($orderData);
        
        $logisticsInfo = config('queue.logistics_info');    //物流公司名称 与 别名
        if ($kuaidiName!=0){
            $kuaidiName = $logisticsInfo[$logisticsInfo];
        }
        if ($orderData['ord_status']==OrderStatus::PAID){   //如果是第一次发货
            $orderModal->save([
                'ord_kuaidi_no' => $kuaidiNo,
                'ord_kuaidi_name' => $kuaidiName,
                'send_good_time' => time(),
                'ord_status' => OrderStatus::SHIPPED
            ],['ord_id'=>$ordId]);
        }else{  //这是修改订单号
            $orderModal->save([
                'ord_kuaidi_no' => $kuaidiNo,
                'ord_kuaidi_name' => $kuaidiName
            ],['ord_id'=>$ordId]);
        }
        
        $this->success('发货成功','Order/orderDetail?id='.$ordId);
    }
    
    /**
     * 订单退款
     */
    public function refundPrice(){
        $orderId = input('param.ord_id');
        $orderModal = new OrderModal();
        $orderInfo = $orderModal->where('ord_id',$orderId)->find();
        if (empty($orderInfo)){
           $this->error('没有查到该订单','Order/orderDetail?id='.$orderId);exit;
        }
        if($orderInfo['ord_status']!=OrderStatus::SALE_RETURN){
            $this->error('该订单不是退款中状态','Order/orderDetail?id='.$orderId);exit;
        }
        //#TODO 去申请退款
        $orderService = new OrderService();
        $orderService->priceRefund($orderInfo);
        $this->success('退款成功','Order/orderDetail?id='.$orderId);
    }
    
    /**
     * 订单完成
     */
    public function finshOrder(){
        $orderId = input('param.ord_id');
        $orderModal = new OrderModal();
        $orderInfo = $orderModal->where('ord_id',$orderId)->find();
        if (empty($orderInfo)){
            $this->error('没有查到该订单','Order/orderDetail?id='.$orderId);exit;
        }
        if($orderInfo['ord_status']!=OrderStatus::SHIPPED || ($orderInfo['send_good_time']+config('queue.order_shipped_days')*3600*24)>time()){
            $this->error('该订单不是已发货状态或者发货没有大于'.config('queue.order_shipped_days').'天','Order/orderDetail?id='.$orderId);exit;
        }
        $orderModal->save(['ord_status'=>OrderStatus::FINISHED],['ord_id'=>$orderId]);
        $this->success('订单完成操作成功','Order/orderDetail?id='.$orderId);
    }
    
    
    
    
    
    
}