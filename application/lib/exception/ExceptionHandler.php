<?php
namespace app\lib\exception;

use think\exception\Handle;
use think\exception\HttpException;
use think\Log;
use think\Request;
class ExceptionHandler extends Handle{
    private $code;
    private $msg;
    private $errorCode;
    /*
     * 自定义异常处理
     */
    public function render(\Exception $e){
        if ($e instanceof BaseException){
            //自定义异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }elseif ($e instanceof HttpException){
            $this->code = 404;
            $this->msg = "http地址错误";
            $this->errorCode = 20000;
            $this->recodeErrorLog($e);
        }else{
            $this->code = 500;
            $this->msg = "服务器内部错误";
            $this->errorCode = 999;
            $this->recodeErrorLog($e);
        }
         if (config('app_debug')){
             return parent::render($e);
         }
        $request = Request::instance();
        $result = [
            'errorCode' => $this->errorCode,
            'msg' => $this->msg,
            'requestUrl' => $request->url()
        ];
        return json($result,$this->code);
    }
    
    /*
     * 记录日志
     */
    private function recodeErrorLog(\Exception $e){
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(),'error');
    }
}