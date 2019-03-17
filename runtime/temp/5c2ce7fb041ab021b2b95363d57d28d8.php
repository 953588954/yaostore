<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\product\category.html";i:1515419271;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1515763734;}*/ ?>
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
  <!-- 添加分类 隐藏模态框 -->
	<div class="add_category_model">
		<div class="title">
			<span >添加分类</span>
			<span onclick="remove_motai('add_category_model')"><img src="/static/images/cancel.png" /></span>
		</div>
		<div class="edit_pwd_table">
		<form name="add_category" action="<?php echo url('Product/addCategory'); ?>" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>分类名:</td>
					<td><input type="text" name="category" /></td>
				</tr>
				<tr>
					<td>分类头图:</td>
					<td><input type="file" name="topic_img" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button onclick="submit_form('add_category')">添加</button></td>
				</tr>
			</table>
		</form>
		</div>
	</div>
	<div class="business_toumingceng"></div>
<!--end 添加分类 -->
<!-- 编辑分类 隐藏模态框 -->
	<div class="edit_category_model">
		<div class="title">
			<span >编辑分类</span>
			<span onclick="remove_motai('edit_category_model')"><img src="/static/images/cancel.png" /></span>
		</div>
		<div class="edit_pwd_table">
		<form name="edit_category" action="<?php echo url('Product/editCategory'); ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="cat_id" value="0" />
			<table>
				<tr>
					<td>分类名:</td>
					<td><input type="text" name="category" /></td>
				</tr>
				<tr>
					<td>分类头图:</td>
					<td><input type="file" name="topic_img" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button onclick="submit_form('edit_category')">确定</button></td>
				</tr>
			</table>
		</form>
		</div>
	</div>
	<!-- <div class="business_toumingceng"></div> -->
<!--end 编辑分类 -->

	<div class="category_main">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th>序号</th>
				<th>分类名称</th>
				<th>分类头图</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
			<?php if(is_array($categorys) || $categorys instanceof \think\Collection || $categorys instanceof \think\Paginator): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $category['cat_name']; ?></td>
				<td><img src="<?php echo $category['img']['ima_url']; ?>" /></td>
				
				<td><?php echo $category['create_time']; ?></td>
				<td>
					<span onclick="editCategory('<?php echo $category['cat_id']; ?>')">编辑</span>
					<span><a href="<?php echo url('Product/deleteCategory',array('id'=>$category['cat_id'])); ?>" onclick="return confirm('此分类下没有商品才可删除，您确定要删除此分类吗？');">删除</a></span>
				</td>
			</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
		<div class="addCategotyBut">
			<button onclick="model_show('add_category_model')">添加分类</button>
		</div>
	</div>

	<script>
		//点击编辑分类
		function editCategory(id){
			$.ajax({
				type:'GET',
				url:'/index.php/Admin/Product/getCategoryById',
				data:{id:id},
				dataType:'json',
				success:function(res){
					if(res.error==0){
						//显示模态框
						model_show('edit_category_model')
						//填充数据
						$(".edit_category_model [name='cat_id']").val(res.data.cat_id);
						$(".edit_category_model [name='category']").val(res.data.cat_name);
					}else{
						alert(res.msg);
					}
				},
				error:function(res){
					alert("ajax请求失败");
				}
			});
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
