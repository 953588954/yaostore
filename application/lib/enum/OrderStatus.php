<?php
namespace app\lib\enum;

class OrderStatus{
    const NO_PAY = 0;   //待付款
    const PAID = 1;     //已付款，待发货
    const SHIPPED = 2;  //已发货
    const PAID_BUT_NOSTOCK = 3; //已付款 单库存不足
    const SALE_RETURN = 4;  //退款中
    const FINISHED = 5;     //完成订单
    const CANCEL = 6;   //已取消订单
    const RETURN_FINNISHED = 7; //退款完成
}