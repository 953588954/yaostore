<?php
namespace app\lib\exception;

class BannerException extends BaseException{
    public $code = 400;
    public $msg = "没有查询到banner数据";
    public $errorCode = 10002;
}