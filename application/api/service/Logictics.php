<?php
/**
 * 物流查询
 */
namespace app\api\service;

//use app\lib\exception\LogicticsException;
class Logictics{
    private $host = "http://wuliu.market.alicloudapi.com";//api访问链接
    private $path = "/kdi";//API访问后缀
    private $method = "GET";
    private $appcode = "f11df786300b4811994815544d7b5238";//阿里云appcode
    
    private $kuaidiNO;  //快递单号
    private $kuaidiName;    //快递公司的type缩写
    
    public function __construct($kuaidiNo,$kuaidiName){
        $this->kuaidiNO = $kuaidiNo;
        $this->kuaidiName = $kuaidiName;
    }
    
    public function getLogictic(){
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $this->appcode);
        if ($this->kuaidiName==0 || empty($this->kuaidiName)){
            $kuaidiName = "";
        }else{
            $kuaidiName = $this->kuaidiName;
        }
        $querys = "no=".$this->kuaidiNO."&type=".$kuaidiName;  //参数写在这里
        $bodys = "";
        $url = $this->host . $this->path . "?" . $querys;//url拼接
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$this->host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $rst = json_decode(curl_exec($curl),true);
        if ($rst['status']!=0){
            //记录日志
            $filename = "./error.txt";
            $fp = fopen($filename, 'a+');
            fwrite($fp, date("Y-m-d H:i:s",time())."查询物流接口出错，错误码：".$rst['status']."错误原因:".$this->getErrorMsg($rst['status'])."\r\n");
            fclose($fp);
            //throw new LogicticsException(['msg'=>'查询物流接口出错，错误码：'.$rst['status'].' 错误原因:'.$this->getErrorMsg($rst['status'])]);
            
        }
        return $rst;
    }
    
    private function getErrorMsg($errCode){
        switch ($errCode){
            case "201":
                return "快递单号错误";
                break;
            case "203":
                return "快递公司不存在";
                break;
            case "204":
                return "快递公司识别失败";
                break;
            case "205":
                return "没有信息";
                break;
            case "207":
                return "该单号被限制，错误单号";
                break;
            default:
                return "未知错误";
        }
    }
}