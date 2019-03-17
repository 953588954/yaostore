<?php
namespace app\lib\exception;

class ProductException extends BaseException{
    public $code = 404;
    public $msg = "没有查到该商品信息";
    public $errorCode = 10010;
}