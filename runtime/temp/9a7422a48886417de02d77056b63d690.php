<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\index\storeinfo.html";i:1513947335;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1515420471;}*/ ?>
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
    <li><a href="list.html"><span class="icon-caret-right"></span>所有订单</a></li>      
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
  	<link href="__CSS__/bootstrap.min.css" rel="stylesheet">
    <link href="__CSS__/bootstrap-fileinput.css" rel="stylesheet">
	<script src="__JS__/bootstrap-fileinput.js"></script>

<div class="store_main">
	<div class="title">
		<span class="on_class" id="store_info" onclick="toggle('store_info','add_info')">店铺信息</span>
		<span class="nomal_title" id="add_info" onclick="toggle('add_info','store_info')">添加店铺</span>
	</div>

	<div class="store_info">
	<?php if(is_array($storeInfo) || $storeInfo instanceof \think\Collection || $storeInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $storeInfo;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
		<div class="storeList">
		<table>
			<tr>
				<td>店铺名称：</td>
				<td><?php echo $val['bus_name']; ?></td>
			</tr>
			<tr>
				<td>营业时间：</td>
				<td><?php echo $val['bus_open_time']; ?></td>
			</tr>
			<tr>
				<td>开店周：</td>
				<td><?php echo $val['bus_open_day']; ?></td>
			</tr>
			<tr>
				<td>热线电话：</td>
				<td><?php echo $val['phone']; ?></td>
			</tr>
			<tr>
				<td>店铺详细地址：</td>
				<td><?php echo $val['bus_address']; ?></td>
			</tr>
			
			<tr>
				<td>店铺描述：</td>
				<td style="font-size: 12px;">
					<?php echo $val['bus_description']; ?>
				</td>
			</tr>
			<tr>
				<td>店铺图片：</td>
				<td><img src="<?php echo $val['img']['ima_url']; ?>" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><a href="<?php echo url('Index/deleteStore',array('id'=>$val['bus_id'])); ?>" onclick="javascript:return confirm('您确定要删除此店铺信息吗？');">删除</a></td>
			</tr>
		</table>
		</div>
	<?php endforeach; endif; else: echo "$empty" ;endif; ?>
	</div>

	<div class="add_info">
		<form action="<?php echo url('Index/addStore'); ?>" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>
					<span class="red_star">*</span>店铺名称：
				</td>
				<td>
					<input type="text" name="bus_name" />
				</td>
			</tr>
			<tr>
				<td>
					<span class="red_star">*</span>营业时间：<br/><span class="red_star">(如：9:00-16:00)</span>
				</td>
				<td>
					<input type="text" name="bus_open_time" />
				</td>
			</tr>
			<tr>
				<td>
					<span class="red_star">*</span>开店周：<br/><span class="red_star">(如：周一到周五)</span>
				</td>
				<td>
					<input type="text" name="bus_open_day" />
				</td>
			</tr>
			<tr>
				<td>
					<span class="red_star">*</span>店铺电话：<br/>
				</td>
				<td>
					<input type="number" name="phone" />
				</td>
			</tr>

			<tr>
				<td>
					<span class="red_star">*</span>店铺详细地址：
				</td>
				<td>
					<input type="text" name="bus_address" />
				</td>
			</tr>
			<tr>
				<td>
					<span class="red_star">*</span>店铺描述：<br/><span class="red_star">(可回车换行)</span>
				</td>
				<td>
					<textarea name="bus_description"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<span class="red_star">*</span>店铺图片：<br/><span class="red_star">(图片大小不能超过2M)</span>
				</td>
				<td>
					<div class="fileinput fileinput-new" data-provides="fileinput"  id="exampleInputUpload">
	                    <div class="fileinput-new thumbnail" style="width: 200px;height: auto;max-height:150px;">
	                        <img id='picImg' style="width: 100%;height: auto;max-height: 140px;" src="/static/images/noimage.png" alt="" />
	                    </div>
	                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
	                    <div>
	                        <span class="btn btn-primary btn-file">
	                            <span class="fileinput-new">选择文件</span>
	                            <span class="fileinput-exists">换一张</span>
	                            <input type="file" name="store_img" id="picID" accept="image/gif,image/jpeg,image/x-png"/>
	                        </span>
	                        <a href="javascript:;" class="btn btn-warning fileinput-exists" data-dismiss="fileinput">移除</a>
	                    </div>
                	</div>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;
				</td>
				<td>
					<!-- <a href="##" class="add_btn">添加</a> -->
					<input type="submit" name="" value="添加" class="add_btn" />
				</td>
			</tr>
		</table>
		</form>
	</div>

</div>
<div class="bottom">
			2017-2018 @coypyright by 铭玺大药房
	</div>


<script>
	$(".store_info").show();
	$(".add_info").hide();

	function toggle(cls1,cls2){
		$("#"+cls1).removeClass("on_class");
		$("#"+cls1).removeClass("nomal_title");
		$("#"+cls2).removeClass("on_class");
		$("#"+cls2).removeClass("nomal_title");
		$("#"+cls1).addClass("on_class");
		$("#"+cls2).addClass("nomal_title");
		$("."+cls1).show();
		$("."+cls2).hide();
	}
	
</script>

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
