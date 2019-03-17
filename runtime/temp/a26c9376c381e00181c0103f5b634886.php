<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\order\allOrders.html";i:1520605027;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1519553941;}*/ ?>
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
  
	<script type="text/javascript" src="__JS__/jquery.min.js"></script>   
	<script type="text/javascript" src="__JS__/jquery.date_input.js"></script>
	<link rel="stylesheet" href="__CSS__/date_input.css" >
	<script type="text/javascript">$($.date_input.initialize);</script>

	<div class="all_orders_container">
		<!-- 搜索条件 -->
		<form action="<?php echo url('Order/allOrders'); ?>" name="search_orders_form" method="get">
		<div class="search_box">
			<div class="search_item">
				<span>订单号：</span>
				<span><input type="text" name="orderNo" value="<?php echo $param['ord_no']; ?>" /></span>
			</div>
			<div class="search_item">
				<span>下单日期：</span>
				<span><input type="text" name="orderStartTime" class="date_input" value="<?php echo $param['starTime']; ?>" readonly /> — <input type="text" value="<?php echo $param['endTime']; ?>" name="orderEndTime" class="date_input" readonly /></span>
			</div>
			<div class="search_item">
				<span>订单状态：</span>
				<span>
					<select name="orderStatus">
						<option value="all_orders" <?php if($param['ord_status'] == 'all_orders'): ?> selected<?php endif; ?>>全部</option>
						<option value="no_pay" <?php if($param['ord_status'] == 'no_pay'): ?> selected<?php endif; ?>>待付款</option>
						<option value="no_shipped" <?php if($param['ord_status'] == 'no_shipped'): ?> selected<?php endif; ?>>待发货</option>
						<option value="shipped" <?php if($param['ord_status'] == 'shipped'): ?> selected<?php endif; ?>>已发货</option>
						<option value="sale_return" <?php if($param['ord_status'] == 'sale_return'): ?> selected<?php endif; ?>>退款中</option>
						<option value="finished" <?php if($param['ord_status'] == 'finished'): ?> selected<?php endif; ?>>已完成</option>
						<option value="refund_finished" <?php if($param['ord_status'] == 'refund_finished'): ?> selected<?php endif; ?>>退款完成</option>
					</select>
				</span>
			</div>
			<div class="search_item">
				<input type="submit" name="search_orders_submit" value="搜索订单" />
			</div>
		</div>
		</form>
		<!-- 搜索结果列表 -->
		<div class="order_list_box">
			<table cellspacing="0" cellpadding="0">
				<tr class="table_title">
					<td>订单号</td>
					<td>商品名称</td>
					<td>商品总数</td>
					<td>总金额</td>
					<td>订单状态</td>
					<td>下单时间</td>
					<td>操作</td>
				</tr>
				<?php if(is_array($orderInfo) || $orderInfo instanceof \think\Collection || $orderInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $orderInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?>
				<tr class="table_list">
					<td><?php echo $order['ord_no']; ?></td>
					<td class="spacing"><?php echo $order['ord_snap_name']; ?></td>
					<td><?php echo $order['ord_total_count']; ?></td>
					<td class="spacing">¥<?php echo $order['ord_freight_price']+$order['ord_product_price']; ?></td>
					<?php switch($order['ord_status']): case "0": ?><td><span class="spacing no_pay">待付款</span></td><?php break; case "1": ?><td><span class="spacing no_shipped">待发货</span></td><?php break; case "2": ?><td><span class="spacing shipped">已发货</span></td><?php break; case "4": ?><td><span class="spacing refund">退款中</span></td><?php break; case "5": ?><td><span class="spacing finished">已完成</span></td><?php break; case "7": ?><td><span class="spacing finished">退款完成</span></td><?php break; endswitch; ?>
					
					<td><?php echo $order['create_time']; ?></td>
					<td><a href="<?php echo url('Order/orderDetail',array('id'=>$order['ord_id'])); ?>" class="chakan_btn">查看</a></td>
				</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				<!--
				<tr class="table_list">
					<td>AC10810179758364</td>
					<td class="spacing">西湖龙井 8克*3袋</td>
					<td>1</td>
					<td class="spacing">¥0.01</td>
					<td><span class="spacing shipped">已发货</span></td>
					<td>2017-12-10 12:43:27</td>
					<td><span class="chakan_btn">查看</span></td>
				</tr>
				<tr class="table_list">
					<td>AC10810179758364</td>
					<td class="spacing">西湖龙井 8克*3袋</td>
					<td>1</td>
					<td class="spacing">¥0.01</td>
					<td><span class="spacing no_pay">待付款</span></td>
					<td>2017-12-10 12:43:27</td>
					<td><span class="chakan_btn">查看</span></td>
				</tr>
				<tr class="table_list">
					<td>AC10810179758364</td>
					<td class="spacing">西湖龙井 8克*3袋</td>
					<td>1</td>
					<td class="spacing">¥0.01</td>
					<td><span class="spacing finished">已完成</span></td>
					<td>2017-12-10 12:43:27</td>
					<td><span class="chakan_btn">查看</span></td>
				</tr> -->

			</table>
		</div>
		<!-- 分页 -->
		<div class="page">
			<?php echo $page; ?>
		</div>
	</div>

	<script>
		//jquery 改变表格背景交替样式
		$(function(){
			$(".all_orders_container .order_list_box .table_list:odd td").css("background-color","#e9e3e3");
		}); 
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
