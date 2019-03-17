<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:81:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\index\storeBanner.html";i:1516187506;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1519553941;}*/ ?>
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
  	<link href="__CSS__/bootstrap.min.css" rel="stylesheet">
    <link href="__CSS__/bootstrap-fileinput.css" rel="stylesheet">
	<script src="__JS__/bootstrap-fileinput.js"></script>
	<style type="text/css">
		.banner_item_main{
			margin: 30px;
		}
		.banner_item_main h1{
			text-align: center;
		}
		.banner_item_main .banner_items{
			width: 100%;
			display: flex;
			flex-wrap: wrap;
			justify-content: space-around;

		}
		.banner_item_main .banner_items .banner_item{
			width: 50%;
			min-height: 100px;
			border:1px solid #ccc;
			margin-top: 30px;
			border-radius: 15px;
			display: flex;
			flex-direction: column;
			align-items: center;

			padding: 20px 0px;
		}
		.banner_item_main .banner_items .banner_item:hover{
			box-shadow: 0px 0px 3px #ADADAD;
		}
		.banner_item_main .upload_btn{
			width: 100%;
			margin-top: 20px;
			text-align: center;
		}
		.banner_item_main .upload_btn button{
			border-radius: 5px;
			padding: 10px 50px;
			border: none;
			letter-spacing: 2px;
			color: #fff;
			font-size: 18px;
			background-color: green;
		}
		.banner_item_main .upload_btn button:hover{
			opacity: 0.8;
		}
		
		.banner-main{
			margin-top: 20px;
		}
		.banner-main table{
			width: 100%;
		}
		.banner-main table th{
			width: 20%;
		}
		.banner-maintable .topic-img{
			width: 40%;
		}
		.banner-main table tr{
			border-bottom: 1px solid #ddd;
			height: 30px;
			line-height: 30px;
			vertical-align: middle;
			text-align: center;
		}
		.banner-main table tr td{
			padding: 5px 0px;
		}
		.banner-main table img{
			max-width: 200px;
			height: auto;
		}
		.banner-main table tr td input[type=submit],.banner-main table tr td a{
			padding: 5px 10px;
			color: #fff;
			background-color: blue;
			border-radius: 3px;
			border:none;
			text-decoration: none;
		}
		.banner-main table tr td input[type=submit]:hover{
			opacity: 0.7;
		}
		#categorySelect select{
			margin-right: 10px;
		}
	</style>

	<div class="banner_item_main">
		<div class="title">
			<span class="on_class" id="freight_info" onclick="toggle('freight_info','add_province')">轮播图设置</span>
			<span class="nomal_title" id="add_province" onclick="toggle('add_province','freight_info')">上传轮播图</span>
		</div>
		
		<div class="freight_info">
			<h1>店铺首页轮播图设置</h1>
			<div class="banner-main">
		
				<table cellpadding="0" cellspacing="0">
					<tr>
						<th>是否启用</th>
						<th class="topic-img">轮播图</th>
						<th >关联商品</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($bannerImgs) || $bannerImgs instanceof \think\Collection || $bannerImgs instanceof \think\Paginator): $i = 0; $__LIST__ = $bannerImgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banner): $mod = ($i % 2 );++$i;?>
					<form action="<?php echo url('Index/setBannerUse'); ?>" method="post">
					<input type="hidden" name="ban_id" value="<?php echo $banner['ban_id']; ?>">
					<tr>
						<td><input type="checkbox" name="is_use" value="1" <?php if($banner['is_use']): ?>checked="checked"<?php endif; ?>></td>
						<td><img src="<?php echo $banner['img']['ima_url']; ?>" /></td>
						<td><?php echo $banner['product']['cate']['cat_name']; ?>:<?php echo $banner['product']['pro_name']; ?></td>
						<td><input type="submit" value="更改" onclick="return confirm('你确定要更改此轮播图状态吗？');" /> <a href="<?php echo url('Index/delBanner',array('ban_id'=>$banner['ban_id'])); ?>" onclick="return confirm('您确定要删除此轮播图吗？')">删除</a></td>
					</tr>
					</form>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					<tr>
						<td colspan="4" style="color: red;text-align: left;font-size: 14px;">注：首页轮播图只能同时启用4~6个</td>
					</tr>
				</table>
		
			</div>
		</div>
		<div class="add_province">
			
			<form name="banner_form" action="<?php echo url('Index/uploadBanners'); ?>" method="post" enctype="multipart/form-data">
			<div class="banner_items store_main ">
				<div class="banner_item add_info">
						<div class="fileinput fileinput-new" data-provides="fileinput"  id="exampleInputUpload">
		                    <div class="fileinput-new thumbnail" style="width: 200px;height: auto;max-height:150px;">

		                        <img id='picImg' style="width: 100%;height: auto;max-height: 140px;" src="/static/images/noimage.png" alt="" />

		                    </div>
		                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
		                    <div>
		                        <span class="btn btn-primary btn-file">
		                            <span class="fileinput-new">选择文件</span>
		                            <span class="fileinput-exists">换一张</span>
		                            <input type="file" name="banner_img" id="picID1" accept="image/gif,image/jpeg,image/x-png"/>
		                        </span>
		                        <a href="javascript:;" class="btn btn-warning fileinput-exists" data-dismiss="fileinput">移除</a>
		                    </div>
	                	</div>
					<div id="categorySelect">
	                	请选择关联商品：
						<select name="category" onchange="findProductByCate()">
							<option value="0">请选择...</option>
							<?php if(is_array($catInfo) || $catInfo instanceof \think\Collection || $catInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $catInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?>
							<option value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['cat_name']; ?></option>
							<?php endforeach; endif; else: echo "" ;endif; ?>

						</select>
					<div>
				</div>
				
			</div>

			<div class="upload_btn">
				<button onclick="submit_form('banner_form')">上传</button>
			</div>
			</form>
		</div>
	</div>

<script type="text/javascript">
	$(".freight_info").show();
	$(".add_province").hide();

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
