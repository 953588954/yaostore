<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

return [
    // 'basic_url' => 'https://www.hkj.cn/',    //域名
    'basic_url' => 'http://yaostore.weixinhkj.xyz/',    //域名
    
    'salt' => 'haokuangjie', //加密的盐
    
    'map_key' => '', //接入腾讯地图api key
    'map_url' => '', //查询地图api 接口
        
    'appid' => '',    //小程序appid
    'secret' => '',     //小程序app_secret
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',  //登录小程序 使用code换取openid
    'token_expire_time' => 7000, //令牌缓存时间
    
    'notify_url' => '',  //微信支付回调接口
    
    'access_token_url' => 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',
        
    /***********
     * 快递物流  公司 与 缩写名对应 
     */
    'logistics_info' => [
        'SFEXPRESS' => '顺丰速运',
        'HTKY' => '百世快递',
        'ZTO' => '中通快递',
        'STO' => '申通快递',
        'YTO' => '圆通快递',
        'YUNDA' => '韵达快递',
        'CHINAPOST' => '邮政快递包裹',
        'TTKDEX' => '天天快递',
        'UC56' => '优速快递',
        'DEPPON' => '德邦',
        'FASTEXPRESS' => '快捷快递',
        'ZJS' => '宅急送'
    ],
    
    /*********
     * 大于多少天  客户端没有点收货，后台显示 确认收货
     */
    'order_shipped_days' => 15,
];
