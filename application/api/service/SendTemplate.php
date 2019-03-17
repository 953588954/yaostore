<?php
namespace app\api\service;

class SendTemplate{
    //发送模板消息url
    private $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=%s";
    //模板消息id
    private $template_id = "EQ698fIJyGFX1l4C_GfBRbz3Xxj3omb5z6Tm92mzpEg";
    //接收者（用户）的 openid
    private $touser;
    //表单提交场景下，为 submit 事件带上的 formId；支付场景下，为本次支付的 prepay_id
    private $form_id;
    
    public function __construct($touser,$form_id){
        $this->touser = $touser;
        $this->form_id = $form_id;
    }
    
    /**
     * 发送模板消息
     */
    public function send($orderInfo){
        $access_token = AccessToken::getAccessToken();
        
        $array['touser'] = $this->touser;
        $array['template_id'] = $this->template_id;
        $array['page'] = "/pages/my/my?orderid=123456";
        $array['form_id'] = $this->form_id;
        $array['data'] = $this->getData($orderInfo);
        $array['emphasis_keyword'] = '';
        
        $url = sprintf($this->url,$access_token);
        $rst = json_decode(curl_post($url,$array),true);
        if ($rst['errcode']!=0){
            $filename = "./error.txt";
            $fp = fopen($filename, 'a+');
            fwrite($fp, date("Y-m-d H:i:s",time())."发送模板消息出错，错误码：".$rst['errcode']."错误原因:".$this->getErrorMsg($rst['errcode'])."\r\n");
            fclose($fp);
        }
    }
    
    /******错误描述*******/
    private function getErrorMsg($errcode){
        $array = [
            '40037' => 'template_id不正确',
            '41028' => 'form_id不正确，或者过期',
            '41029' => 'form_id已被使用',
            '41030' => 'page不正确',
            '45009' => '接口调用超过限额（目前默认每个帐号日调用限额为100万）'
        ];
        if (array_key_exists($errcode, $array)){
            return $array[$errcode];
        }else{
            return "未知错误";
        }
    }
    
    /*****模板内容******/
    private function getData($orderInfo){
        $time_end = substr($orderInfo['time_end'], 0,4)."-".substr($orderInfo['time_end'], 4,2)."-".substr($orderInfo['time_end'], 6,2)." ".substr($orderInfo['time_end'], 8,2).":".substr($orderInfo['time_end'], 10,2).":".substr($orderInfo['time_end'], 12);
        $price = $orderInfo['ord_freight_price']+$orderInfo['ord_product_price'];
        if (empty($orderInfo['send_good_time'])){
            $send_time = date("Y-m-d H:i:s",time());
        }else{
            $send_time = date("Y-m-d H:i:s",$orderInfo['send_good_time']);
        }
        $data = [
            'keyword1' => ['value'=>$orderInfo['ord_snap_name']],
            'keyword2' => ['value'=>'铭玺大药房'],
            'keyword3' => ['value'=>$orderInfo['ord_no']],
            'keyword4' => ['value'=>"¥".$price,'color'=>'#ff0000'],
            'keyword5' => ['value'=>$time_end],
            'keyword6' => ['value'=>$send_time] 
        ];
        return $data;
    }
    
    
}