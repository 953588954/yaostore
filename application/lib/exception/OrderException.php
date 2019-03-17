<?php
namespace app\lib\exception;

class OrderException extends BaseException{
    public $code=400;
    public $msg = "订单创建失败";
    public $errorCode = 30000;
}