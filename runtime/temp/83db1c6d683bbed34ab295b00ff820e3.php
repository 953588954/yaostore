<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\index\index.html";i:1516187508;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1519553941;}*/ ?>
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
  
<!-- 修改密码 隐藏模态框 -->
	<div class="business_edit_pwd">
		<div class="title">
			<span >修改密码</span>
			<span onclick="remove_motai('business_edit_pwd')"><img src="/static/images/cancel.png" /></span>
		</div>
		<div class="edit_pwd_table">
		<form name="edit_pwd" action="<?php echo url('Index/editPwd'); ?>" method="post">
			<table>
				<tr>
					<td>用户名：</td>
					<td><?php echo \think\Session::get('rootInfo')['root_name']; ?></td>
				</tr>
				<tr>
					<td>预留手机号：</td>
					<td><input type="number" name="phone" /></td>
				</tr>
				<tr>
					<td>新密码：</td>
					<td><input type="password" name="new_pwd" /></td>
				</tr>
				<tr>
					<td>确认密码：</td>
					<td><input type="password" name="check_pwd" /></td>
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
<!--end 修改密码 -->
<div class="business_contanier">
		<div class="user_tip">
			<img src="/static/images/sun.png" />
			<span><?php echo \think\Session::get('rootInfo')['root_name']; ?> 早上好，欢迎使用信息管理系统</span>

		</div>
		<div class="user_lasttime">
			<img src="/static/images/time.png" />
			<span>您上次登录的时间：<?php echo date("Y-m-d H:i:s",\think\Session::get('rootInfo')['root_last_time']); ?> （不是您登录的？&nbsp;<span style="color: #3186c8;cursor: pointer;" onclick="model_show('business_edit_pwd')">请点这里</span>）</span>

		</div>
		<div class="line"></div>
		
	</div>
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
