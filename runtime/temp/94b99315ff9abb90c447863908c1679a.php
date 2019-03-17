<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\product\freight.html";i:1516187499;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1519553941;}*/ ?>
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
  <!-- ajax修改价格成功后提示框 -->
	<div class="success_tip">
		<img src="/static/images/success.png" width="80px" height="50px" /> 修改成功
	</div>
 <!-- end -->
<div class="freight_main">
	<div class="title">
		<span class="on_class" id="freight_info" onclick="toggle('freight_info','add_province')">运费设置</span>
		<span class="nomal_title" id="add_province" onclick="toggle('add_province','freight_info')">添加省市</span>
	</div>

	<div class="freight_info">
		<div class="main">
			<div class="main_top">
				<span>省</span>
				<span>市</span>
				<span>运费（元）</span>
				<span>操作</span>
			</div>
			<div class="main_left">
				<?php if(is_array($provinces) || $provinces instanceof \think\Collection || $provinces instanceof \think\Paginator): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
				<div class="province_item <?php if($val['fre_id'] == 1): ?>on<?php endif; ?>" freid="<?php echo $val['fre_id']; ?>" onclick="province_click(this)"><?php echo $val['fre_region']; ?></div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				
			</div>
			<div class="main_right">
				<div class="city_item">
					<div class="city"><?php echo $sheng['fre_region']; ?></div>
					<div><input type="number" value="<?php echo $sheng['fre_price']; ?>" id="pre_<?php echo $sheng['fre_id']; ?>" /></div>
					<div class="edit"><a href="javascript:void();" onclick="price_edit('<?php echo $sheng['fre_id']; ?>')">修改</a></div>
				</div>	
				<?php if(is_array($regions) || $regions instanceof \think\Collection || $regions instanceof \think\Paginator): $i = 0; $__LIST__ = $regions;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$region): $mod = ($i % 2 );++$i;?>
				<div class="city_item">
					<div class="city"><?php echo $region['fre_region']; ?></div>
					<div><input type="number" value="<?php echo $region['fre_price']; ?>" id="pre_<?php echo $region['fre_id']; ?>" /></div>
					<div class="edit"><a href="javascript:void();" onclick="price_edit('<?php echo $region['fre_id']; ?>')">修改</a></div>
				</div>		
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>

			
		</div>
		<div class="freight_tip">注：(设置运费-1，则该地区不配送。默认运费为0，不收运费。若设置省级运费不为0，则该省下所有地区运费跟随省级)</div>
	</div>

	<div class="add_province">
		<form action="<?php echo url('Product/provinceAdd'); ?>" name="add_province_form" method="get">
		<div class="add_">
			<span>
			省/自治区/直辖市：<input type="text" name="province_name" /> 
			</span>
			<span><button onclick="submit_form('add_province_form')">添加</button></span>
		</div>
		</form>
		<form action="<?php echo url('Product/regionAdd'); ?>" method="post" name="add_region_form">
		<div class="add_city">
			<h1>添加城市</h1>
			<table>
				<tr>
					<td>选择省份：</td>
					<td>
						<select name="pid">
							<option value="0">请选择....</option>
							<?php if(is_array($provinces) || $provinces instanceof \think\Collection || $provinces instanceof \think\Paginator): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$province): $mod = ($i % 2 );++$i;?>
								<option value="<?php echo $province['fre_id']; ?>"><?php echo $province['fre_region']; ?></option>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>城市：</td>
					<td><input type="text" name="region_name[]" /> <span class="add_btn" onclick="add_input(this)">+</span> </td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button onclick="submit_form('add_region_form')">添加</button></td>
				</tr>
			</table>
		</div>
		</form>
		<div class="delete_city">
			<form name="delte_region" method="post" action="<?php echo url('Product/delProvinceOrRegion'); ?>">
			<h1>删除省/市</h1>
			<div class="del_province first">
				<div>选择省份：</div>
				<div>
					<select onchange="region_select()" id="province" name="province">
						<option value="0">请选择...</option>
						<?php if(is_array($provinces) || $provinces instanceof \think\Collection || $provinces instanceof \think\Paginator): $i = 0; $__LIST__ = $provinces;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$province): $mod = ($i % 2 );++$i;?>
							<option value="<?php echo $province['fre_id']; ?>" ><?php echo $province['fre_region']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>
			<div class="del_region del_province">
				<div>选择市/区：</div>
				<div >
					<select name="region" id="region">
						<option value="0">请选择...</option>
					</select>
				</div>
			</div>
			<div class="del_button">
				<button onclick="return befor_sub('delte_region')">删除</button>
			</div>
			<div class="description">注：若只选择省，不选择市/区，则删除此省份及全部下属市区</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(".success_tip").hide();
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

	function add_input(the){
		var str = "<tr><td>&nbsp;</td><td><input type='text' name='region_name[]' /> <span class='add_btn' onclick='add_input(this)'>+</span></td></tr>";
			//console.log($(the));
		$(the).parent().parent().after(str);
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
