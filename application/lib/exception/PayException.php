<?php
namespace app\lib\exception;

class PayException extends BaseException{
    public $code=400;
    public $msg = "微信支付失败";
    public $errorCode = 40000;
}