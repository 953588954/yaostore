<?php
use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];

//获取banner轮播图片
Route::get("api/:version/banner","api/:version.Banner/getBannerItems");

//获取随机10条商品
Route::get("api/:version/products/random","api/:version.Product/getRandomProducts");
//获取某一个商品详细信息 ?id=
Route::get("api/:version/product","api/:version.Product/getProductInfoById");
//模糊查询商品
Route::post("api/:version/products/search","api/:version.Product/searchProducts");


//获取主题 及商品 ?theme='all'
Route::get("api/:version/theme","api/:version.Theme/getThemes");

//获取所有分类
Route::get("api/:version/categorys","api/:version.Category/getAllCategory");
//根据分类id，分类头图id 获取 头图,商品信息
Route::get("api/:version/category/products","api/:version.Category/getProductsByCategory");

//获取token令牌
Route::post("api/:version/token","api/:version.Token/getToken");
//检测令牌是否过期
Route::post("api/:version/verifyToken","api/:version.Token/verifyToken");

//查询购物车种商品 返回最新商品信息
Route::post("api/:version/newsProduct","api/:version.Cart/checkCartProducts");

//查询收货地址 和 邮费
Route::post("api/:version/address_postage","api/:version.Address/getAddressAndPostage");
//添加地址
Route::post("api/:version/address_add","api/:version.Address/addAddress");
//获取所有地址
Route::get("api/:version/allAddress","api/:version.Address/getAllAddress");
//删除某一个地址
Route::get("api/:version/address_del","api/:version.Address/delAddressById");
//设置默认地址
Route::get("api/:version/address_default","api/:version.Address/setDefaultAddress");

//保存用户微信信息
Route::post("api/:version/userInfo","api/:version.User/saveUserInfo");

//获取门店信息
Route::get("api/:version/store","api/:version.Business/getStoreInfo");

//上传商品评论
Route::post("api/:version/comment/word","api/:version.Comment/wordAndImgComment");
//上传评论图片
Route::post("api/:version/comment/img","api/:version.Comment/uploadImg");
//上传评论语音
Route::post("api/:version/comment/voice","api/:version.Comment/yuyinComment");
//获取商品评论
Route::get("api/:version/comments","api/:version.Comment/getCommentsById");


//下单
Route::post("api/:version/place_order","api/:version.Order/placeOrder");
//用户获取订单列表
Route::get("api/:version/order_list","api/:version.Order/getOrderList");
//用户取消待支付的订单
Route::get("api/:version/order_cancel","api/:version.Order/cancelOrder");
//用户删除已取消的订单
Route::get("api/:version/order_delete","api/:version.Order/deleteOrder");
//用户查看订单详情
Route::get("api/:version/order_detail","api/:version.Order/getOrderDetail");
//用户查看订单物流
Route::get("api/:version/order_logistic","api/:version.Order/getLogisticsInfo");
//用户确认收货
Route::get("api/:version/order_confirm","api/:version.Order/confirmReceipt");
//用户申请退款
Route::post("api/:version/order_refund","api/:version.Order/refundOrder");
//用户完成订单
//Route::post("api/:version/order_finsh","api/:version.Order/finshOrder");


//微信获取支付签名
Route::get("api/:version/pay/pay","api/:version.Pay/pay");
//微信支付 回调函数
Route::any("api/:version/pay/notify","api/:version.Pay/receiveNotify");


//测试从模板消息进入的参数
Route::get("api/:version/test/template","api/:version.User/test");
