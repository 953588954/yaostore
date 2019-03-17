<?php
namespace app\lib\exception;

class GetOpenidException extends BaseException{
    public $code = 400;
    public $msg = "获取openid失败";
    public $errorCode = 10006;
}