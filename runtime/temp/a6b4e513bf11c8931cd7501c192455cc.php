<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:81:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\order\orderDetail.html";i:1520660610;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1519553941;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>后台管理中心</title>  
    <link rel="stylesheet" href="__CSS__/pintuer.css">
    <link rel="stylesheet" href="__CSS__/admin.css">
    <link rel="stylesheet" href="__CSS__/business.css">
    <script src="__JS__/jquery-3.2.1.min.js"></script>  
    <script src="__JS__/main.js"></script>  
    <style type="text/css">
      .leftnav h2 img{
          margin-right: 9px;
      }
    </style> 
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
    <h1><img src="/static/images/y.jpg" class="radius-circle rotate-hover" height="50" alt="" />后台管理中心</h1>
  </div>
  <div class="head-l">  <span style="color:#fff"><?php echo \think\Session::get('rootInfo')['role_name']; ?> <?php echo \think\Session::get('rootInfo')['root_name']; ?></span>&nbsp;&nbsp;<a class="button button-little bg-red" href="/index.php/admin/Login/goOut"><span class="icon-power-off"></span> 退出登录</a> </div>
</div>
<div class="leftnav">
  <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
  <h2><img src="/static/images/service.png" width="15px" height="15px" />基本信息</h2>
  <ul style="display:block">
    <li><a href="<?php echo url('index/index'); ?>" ><span class="icon-caret-right"></span>个人信息</a></li>
    <li><a href="<?php echo url('index/storeInfo'); ?>"><span class="icon-caret-right"></span>门店信息</a></li>
  </ul>   
  <h2><img src="/static/images/store_edit.png" width="15px" height="15px" />网店设置</h2>
  <ul>
    <li><a href="<?php echo url('Index/storeBanner'); ?>"><span class="icon-caret-right"></span>轮播图设置</a></li>
    <li><a href="<?php echo url('Index/theme'); ?>"><span class="icon-caret-right"></span>主题设置</a></li>       
  </ul>  
  <h2><img src="/static/images/Category.png" width="15px" height="15px" />商品管理</h2>
  <ul>
    <li><a href="<?php echo url('Product/product'); ?>"><span class="icon-caret-right"></span>所有商品</a></li>    
    <li><a href="<?php echo url('Product/freight'); ?>"><span class="icon-caret-right"></span>运费设置</a></li>
    <li><a href="<?php echo url('Product/category'); ?>"><span class="icon-caret-right"></span>商品分类</a></li>
    <li><a href="<?php echo url('Product/productAddIndex'); ?>"><span class="icon-caret-right"></span>添加商品</a></li>     
  </ul>  

  <h2><img src="/static/images/all.png" width="15px" height="15px" />订单管理</h2>
  <ul>
    <li><a href="<?php echo url('Order/allOrders'); ?>"><span class="icon-caret-right"></span>所有订单</a></li>      
  </ul> 

  <h2><img src="/static/images/account.png" width="15px" height="15px" />顾客管理</h2>
  <ul>
    <li><a href="list.html"><span class="icon-caret-right"></span>顾客信息</a></li>      
  </ul>  

  <h2><img src="/static/images/delete.png" width="15px" height="15px" />回收站</h2>
  <ul>
    <li><a href="list.html"><span class="icon-caret-right"></span>删除的商品</a></li>
    <li><a href="add.html"><span class="icon-caret-right"></span>删除的订单</a></li>      
  </ul>  
  <h2><img src="/static/images/set.png" width="15px" height="15px"  /></span>权限设置</h2>
  <ul>
    <li><a href="<?php echo url('Auth/root'); ?>"><span class="icon-caret-right"></span>用户管理</a></li>
    <li><a href="<?php echo url('Auth/role'); ?>"><span class="icon-caret-right"></span>角色管理</a></li> 
    <li><a href="<?php echo url('Auth/auth'); ?>"><span class="icon-caret-right"></span>权限管理</a></li>      
  </ul> 
</div>

<ul class="bread">
  <li><a target="right" class="icon-home"> <?php echo $navigation1; ?></a></li>
  <li><a  id="a_leader_txt"><?php echo $navigation2; ?></a></li>
  <li><b>当前语言：</b><span style="color:red;">中文</span></li>
</ul>

<div class="admin" style="height: auto;">
	<!--  
  <iframe scrolling="auto" rameborder="0" src="info.html" name="right" width="100%" height="100%"></iframe>
  -->
  <!-- 发货 隐藏模态框 -->
	<div class="business_edit_pwd">
		<div class="title">
			<span >发货</span>
			<span onclick="remove_motai('business_edit_pwd')"><img src="/static/images/cancel.png" /></span>
		</div>
		<div class="edit_pwd_table">
		<form name="edit_pwd" action="<?php echo url('Order/sendGoods'); ?>" method="post">
			<input type="hidden" name="ord_id" value="<?php echo $orderInfo['ord_id']; ?>" />
			<table>
				<tr>
					<td>物流公司：</td>
					<td>
						<select name="ord_kuaidi_name">
							<option value="0">-选择快递公司-</option>
							<?php if(is_array($logisticsInfo) || $logisticsInfo instanceof \think\Collection || $logisticsInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $logisticsInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
								<option value="<?php echo $key; ?>" <?php if($key == $orderInfo['ord_kuaidi_name']): ?>selected<?php endif; ?>><?php echo $val; ?></option>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>快递单号：</td>
					<td>
						<input type="text" name="ord_kuaidi_no" value="<?php echo $orderInfo['ord_kuaidi_no']; ?>" />
						
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td><button onclick="submit_form('edit_pwd')">确定</button></td>
				</tr>
			</table>
		</form>
		</div>
	</div>
	<div class="business_toumingceng"></div>
<!--end 发货 -->

<!-- 修改收货地址 隐藏模态框 -->
	<div class="business_edit_pwd2">
		<div class="title">
			<span >修改收货地址</span>
			<span onclick="remove_motai('business_edit_pwd2')"><img src="/static/images/cancel.png" /></span>
		</div>
		<div class="edit_pwd_table">
		<form name="edit_address" action="<?php echo url('Order/editOrderAddress'); ?>" method="post">
			<input type="hidden" name="ord_id" value="<?php echo $orderInfo['ord_id']; ?>" />
			<input type="hidden" name="add_default" value="<?php echo $orderInfo['ord_snap_address']['add_default']; ?>" />
			<input type="hidden" name="user_id" value="<?php echo $orderInfo['ord_snap_address']['user_id']; ?>" />
			<input type="hidden" name="add_id" value="<?php echo $orderInfo['ord_snap_address']['add_id']; ?>" />
			<table>
				<tr>
					<td>收件人：</td>
					<td><input type="text" name="shou_jian_ren" value="<?php echo $orderInfo['ord_snap_address']['add_name']; ?>" /></td>
				</tr>
				<tr>
					<td>联系方式：</td>
					<td><input type="text" name="lian_xi_fang_shi" value="<?php echo $orderInfo['ord_snap_address']['add_phone']; ?>" /></td>
				</tr>
				<tr>
					<td>收货地区：</td>
					<td><span id="province"><?php echo $orderInfo['ord_snap_address']['add_province']; ?> <?php echo $orderInfo['ord_snap_address']['add_city']; ?> <?php echo $orderInfo['ord_snap_address']['add_country']; ?> </span><button type="button" style="padding: 2px 4px;border-radius: 2px;background-color: #ff3333;margin-left:10px;border:none;" onclick="edit_province_(this)">修改</button></td>
					

				</tr>
				<tr>
					<td>详细地址：</td>
					<td><input type="text" name="xiang_xi_di_zhi" value="<?php echo $orderInfo['ord_snap_address']['add_detail']; ?>" /></td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td><button onclick="submit_form('edit_address')">确定</button></td>
				</tr>
			</table>
		</form>
		</div>
	</div>
<!--end 收货地址 -->

	<div class="order_detail_container">
		<div class="order_detail_title">
			<span>订单详情</span>
			<span><a href="<?php echo url('Order/allOrders'); ?>">返回</a></span>
		</div>
		<!-- 订单信息 -->
		<div class="order_info">
			<div class="order_info_title">订单信息</div>
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="15%" rowspan="3">&nbsp;</td>
					<td width="10%" rowspan="3" class="td_name">订单号：</td>
					<td width="25%" rowspan="3" class="td_content"><?php echo $orderInfo['ord_no']; ?></td>
					<td width="10%" rowspan="3" class="td_name">订单状态：</td>
					<td width="15%" rowspan="3" class="td_content order_status">
						<?php switch($orderInfo['ord_status']): case "0": ?>待付款<?php break; case "1": ?>待发货<?php break; case "2": ?>已发货<?php break; case "4": ?>退款中<?php break; case "5": ?>交易完成<?php break; case "7": ?>退款完成<?php break; endswitch; ?>
					</td>

					<td width="10%" class="td_name">下单时间：</td>
					<td width="15%" colspan="2" class="td_content"><?php echo $orderInfo['create_time']; ?></td>
					<tr>
						<td width="10%" class="td_name">支付时间：</td>
						<td width="15%" colspan="2" class="td_content"><?php echo $orderInfo['time_end']; ?></td>
					</tr>
					<tr>
						<td width="10%" class="td_name">发货时间：</td>
						<td width="15%" colspan="2" class="td_content"><?php echo $orderInfo['send_good_time']; ?></td>
					</tr>
				</tr>
				
				<?php if(is_array($orderInfo['ord_snap_items']) || $orderInfo['ord_snap_items'] instanceof \think\Collection || $orderInfo['ord_snap_items'] instanceof \think\Paginator): $i = 0; $__LIST__ = $orderInfo['ord_snap_items'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?>
				<tr>
					<td width="15%" style="text-align: center;"><img src="<?php echo $order['ima_url']; ?>" /></td>
					<td width="10%" class="td_name">商品名：</td>
					<td width="25%" class="td_content"><?php echo $order['pro_name']; ?></td>
					<td width="10%" class="td_name">单价：</td>
					<td width="15%" class="td_content">¥<?php echo $order['pro_price']; ?></td>
					<td width="10%" class="td_name">数量：</td>
					<td width="15%" class="td_content"><?php echo $order['counts']; ?></td>
				</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>

			</table>
			<div class="price">
				<span>商品总价格：¥<?php echo $orderInfo['ord_product_price']; ?></span>
				<span>配送费：¥<?php echo $orderInfo['ord_freight_price']; ?></span>
			</div>
			<div class="total_price">
				<span>总付款：¥<?php echo $orderInfo['ord_product_price']+$orderInfo['ord_freight_price']; ?></span>
				<span>
					<?php if($orderInfo['ord_status'] == 1): ?>
					<button type="button" onclick="model_show('business_edit_pwd')">发货</button>
					<?php endif; if(($orderInfo['ord_status'] == 2) OR ($orderInfo['ord_status'] == 5)): ?>
					<button type="button"  onclick="model_show('business_edit_pwd')">修改快递单号</button>
					<?php endif; if($orderInfo['ord_status'] == 4): ?>
					<a href="<?php echo url('Order/refundPrice',array('ord_id'=>$orderInfo['ord_id'])); ?>" onclick="return confirm('您确定要为此用户退款吗？');">确认退款</a>
					<div style="color:red;width:300px;height:60px;overflow:auto;margin-top:10px;border:1px solid #333;background-color:#d1d1d1;border-radius: 2px;font-size: 12px;font-weight: normal;">退款理由：<?php echo $orderInfo['refund_content']; ?></div>
					<?php endif; if($orderInfo['show_finish'] == 1): ?>
					<a href="<?php echo url('Order/finshOrder',array('ord_id'=>$orderInfo['ord_id'])); ?>" onclick="return confirm('订单发货大于'+<?php echo $orderInfo['show_finish_day']; ?>+'天，您要手动完成订单？');">订单完成</a>
					<?php endif; ?>

				</span>
			</div>
		</div>

		<div class="address_title">
			<div class="order_info_title">收货信息</div>
			<div class="address_info">
				<div class="consignee">
					<span class="consignee_title">收件人:</span>
					<span class="consignee_content"><?php echo $orderInfo['ord_snap_address']['add_name']; ?></span>
					<span class="consignee_title">联系方式:</span>
					<span class="consignee_content"><?php echo $orderInfo['ord_snap_address']['add_phone']; ?></span>
				</div>
				<div class="consignee">
					<span class="consignee_title">省:</span>
					<span class="consignee_content"><?php echo $orderInfo['ord_snap_address']['add_province']; ?></span>
					<span class="consignee_title">市:</span>
					<span class="consignee_content"><?php echo $orderInfo['ord_snap_address']['add_city']; ?></span>
					<span class="consignee_title">区:</span>
					<span class="consignee_content"><?php echo $orderInfo['ord_snap_address']['add_country']; ?></span>
				</div>
				<div class="consignee">
					<span class="consignee_title">详细地址:</span>
					<span class="consignee_content"><?php echo $orderInfo['ord_snap_address']['add_detail']; ?></span>
					<span><button onclick="model_show('business_edit_pwd2')">修改地址</button></span>
				</div>
				
			</div>
		</div>

		<div class="address_title">
			<div class="order_info_title">物流信息</div>
			<?php if($orderInfo['logistics'] == ''): ?>
			 <div class="no_wuliu">暂无信息</div> 
			 <?php else: if($orderInfo['logistics']['status'] == 0): if(is_array($orderInfo['logistics']['result']['list']) || $orderInfo['logistics']['result']['list'] instanceof \think\Collection || $orderInfo['logistics']['result']['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $orderInfo['logistics']['result']['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
					<div class="wuliu_item"> <!-- #4fc988 -->
						<span><?php echo $item['time']; ?></span>
						<span><?php echo $item['status']; ?></span>
					</div>
					<?php endforeach; endif; else: echo "" ;endif; else: ?>
					<div style="color: red;width: 100%;height: 80px;display: flex;justify-content: center;align-items: center;font-size: 26px;font-weight: bolder;">查询失败：<?php echo $orderInfo['logistics']['status']; ?> <?php echo $orderInfo['logistics']['msg']; ?></div>
			 	<?php endif; endif; ?>
			
		</div>

	</div>

	<script>
		$(function(){
			$(".order_detail_container .address_title .wuliu_item:eq(0)").css('color','#3399ff');
			//get_freight();
		});


		function edit_province_(the){
			var pid=0;

			var params = {
				'type':'GET',
				'url':'/index.php/admin/Product/getRegionsByAjax',
				'data':{province_id:pid},
				sCallback:function(res){
					if(res.error==0){
						$(the).remove();
						var html = "";
						html += "<select name='province' onchange='edit_city_(this)'>";

						var obj = res.data,
							len = obj.length;
						for(var i=0;i<len;i++){
							html +="<option value='"+obj[i].fre_id+"'>"+obj[i].fre_region+"</option>";
						}
						html += "</select>";

						$('#province').html(html);
					}else{
						alert(res.msg);
					}
					
				}
			};
			ajaxRequest(params);			
		}

		function edit_city_(the){
			var pid = $(the).val();

			var params = {
				'type':'GET',
				'url':'/index.php/admin/Product/getRegionsByAjax',
				'data':{province_id:pid},
				sCallback:function(res){
					if(res.error==0){
						var html = "";
						html += "<select name='city'>";

						var obj = res.data,
							len = obj.length;
						for(var i=0;i<len;i++){
							html +="<option value='"+obj[i].fre_id+"'>"+obj[i].fre_region+"</option>";
						}
						html += "</select>";

						$(the).nextAll().remove();
						$(the).parent().append(html);
						var country = "<input type='text' name='country' placeholder='区/县/镇' style='margin-bottom:10px;' />"
						$(the).parent().append(country);
					}else{
						alert(res.msg);
					}
					
				}
			};
			ajaxRequest(params);	
		}

		</script>

	<div class="bottom">
			2017-2018 @coypyright by 铭玺大药房
	</div>

</div>


<script type="text/javascript">
$(function(){
  $(".leftnav h2:first").next().slideToggle(200);

  $(".leftnav h2").click(function(){
	  $(this).next().slideToggle(200);	
	  $(this).toggleClass("on"); 
  })
  // $(".leftnav ul li a").click(function(){
	 //  //alert($(this).text());
	 //    $("#a_leader_txt").text($(this).text());
  // 		$(".leftnav ul li a").removeClass("on");
		// $(this).addClass("on");
  // })
});
</script>
</body>
</html>
