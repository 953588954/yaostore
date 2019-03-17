<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/*
 * ajax 检测id正整数 
 */
function checkID($id){
    if (is_numeric($id) && ($id+0)>0 && is_int($id+0)){
        return ;
    }else {
        echo json_encode([
            'error' => 1,
            'msg' => "参数id必须为正整数"
        ]);
        exit;
    }
}

/*
 * 发送get请求
 */
function curl_get($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //不做证书校验，linux下改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}

/**
 * @param string $url post请求地址
 * @param array $params
 * @return mixed
 */
function curl_post($url, array $params = array())
{
    $data_string = json_encode($params);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt(
    $ch, CURLOPT_HTTPHEADER,
    array(
    'Content-Type: application/json'
        )
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}

/*
 * 生成指定长度的随机字符串
 */
function getRandChars($length=32)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol)-1;

    for ($i=0;$i<$length;$i++){
        $str.=$strPol[rand(0,$max)];
    }

    return $str;
}


