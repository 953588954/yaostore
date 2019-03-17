<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:73:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\auth\auth.html";i:1516187512;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1519553941;}*/ ?>
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
  <!-- 添加权限 隐藏模态框 -->
	<div class="add_auth">
		<div class="title">
			<span >添加权限</span>
			<span onclick="remove_motai('add_auth')"><img src="/static/images/cancel.png" /></span>
		</div>
		<div class="add_auth_table">
			<form action="<?php echo url('Auth/addAuth'); ?>" method="post" name="addauth">
			<table>
				<tr>
					<td>权限名：</td>
					<td><input type="text" name="auth_name" /></td>
				</tr>
				<tr>
					<td>权限父级：</td>
					<td>
						<select name="auth_pid">
							<option value="0">顶级权限</option>
							<?php if(is_array($firstLevel) || $firstLevel instanceof \think\Collection || $firstLevel instanceof \think\Paginator): $i = 0; $__LIST__ = $firstLevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$firstVal): $mod = ($i % 2 );++$i;?>
								<option value="<?php echo $firstVal['auth_id']; ?>">---<?php echo $firstVal['auth_name']; ?></option>
								<?php if(is_array($secondLevel) || $secondLevel instanceof \think\Collection || $secondLevel instanceof \think\Paginator): $i = 0; $__LIST__ = $secondLevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$secondVal): $mod = ($i % 2 );++$i;if($secondVal['auth_pid'] == $firstVal['auth_id']): ?>
										<option value="<?php echo $secondVal['auth_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $secondVal['auth_name']; ?></option>
									<?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>控制器：</td>
					<td><input type="text" name="auth_c" /></td>
				</tr>
				<tr>
					<td>方法名：</td>
					<td><input type="text" name="auth_a" /></td>
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td><button onclick="submit_form('addauth')">确定</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<div class="business_toumingceng"></div>
<!--end 添加权限 -->

	<div class="auth_main">
		<div class="but">
			<button onclick="model_show('add_auth')">添加权限</button>
		</div>
		<div class="auth_main_tab">
		<?php if(is_array($firstLevel) || $firstLevel instanceof \think\Collection || $firstLevel instanceof \think\Paginator): $i = 0; $__LIST__ = $firstLevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val1): $mod = ($i % 2 );++$i;?>
			<div class="first_title">
				<img src="/static/images/cancel.png"> <?php echo $val1['auth_name']; ?>
			</div>
			<?php if(is_array($secondLevel) || $secondLevel instanceof \think\Collection || $secondLevel instanceof \think\Paginator): $i = 0; $__LIST__ = $secondLevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val2): $mod = ($i % 2 );++$i;if($val2['auth_pid'] == $val1['auth_id']): ?>
				<div class="second_main">
					<div class="second_title">
						<img src="/static/images/cancel.png"> <?php echo $val2['auth_name']; ?>
					</div>
					<div class="third_title">
					<?php if(is_array($thirdLevel) || $thirdLevel instanceof \think\Collection || $thirdLevel instanceof \think\Paginator): $i = 0; $__LIST__ = $thirdLevel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val3): $mod = ($i % 2 );++$i;if($val3['auth_pid'] == $val2['auth_id']): ?>
						<span><img src="/static/images/cancel.png"> <?php echo $val3['auth_name']; ?></span>
						<?php endif; endforeach; endif; else: echo "" ;endif; ?>
						
					</div>
				</div>
				<?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
			
		</div>

		
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
