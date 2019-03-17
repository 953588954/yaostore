<?php
namespace app\lib\exception;

class LogicticsException extends BaseException{
    public $code=400;
    public $msg = "物流查询失败";
    public $errorCode = 50000;
}