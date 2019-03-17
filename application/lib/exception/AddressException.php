<?php
namespace app\lib\exception;

class AddressException extends BaseException{
    public $code = 403;
    public $msg = "没有此权限";
    public $errorCode = 10011;
        
}