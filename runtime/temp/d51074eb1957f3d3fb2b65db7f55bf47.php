<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:87:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\product\productaddindex.html";i:1515413577;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1515763734;}*/ ?>
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
  <!-- 添加剂型 隐藏模态框 -->
	<div class="business_edit_pwd">
		<div class="title">
			<span >添加剂型</span>
			<span onclick="remove_motai('business_edit_pwd')"><img src="/static/images/cancel.png" /></span>
		</div>
		<div class="edit_pwd_table">
		<form name="add_dosage" action="<?php echo url('Product/addDosage'); ?>" method="post">
			<table>
				<tr>
					<td>剂型名:</td>
					<td><input type="text" name="dosage" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button onclick="submit_form('add_dosage')">添加</button></td>
				</tr>
			</table>
		</form>
		</div>
	</div>
	<div class="business_toumingceng"></div>
<!--end 添加剂型 -->



	<div class="product_main">
		<div class="title">
			<div class="on" attr="attr_gong">共有属性</div>
			<div attr="attr_fei">非必须属性</div>
		</div>
		<div class="product_attr">
		<form action="<?php echo url('Product/addProduct'); ?>" method="post" name="add_product" enctype="multipart/form-data">
			<div class="attr_gong">
				<table>
					<tr>
						<td>商品名：</td>
						<td><input type="text" name="name" /></td>
					</tr>
					<tr>
						<td>规格：</td>
						<td><input type="text" placeholder="3.5g*10包" name="specification" /></td>
					</tr>
					<tr>
						<td>价格：</td>
						<td><input type="text" name="price" /></td>
					</tr>
					<tr>
						<td>库存：</td>
						<td><input type="number" name="stock" /></td>
					</tr>
					<tr>
						<td>剂型：</td>
						<td>
							<select name="dosage">
								<option value="0">请选择...</option>
								<?php if(is_array($dosages) || $dosages instanceof \think\Collection || $dosages instanceof \think\Paginator): $i = 0; $__LIST__ = $dosages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dosage): $mod = ($i % 2 );++$i;?>	
								<option value="<?php echo $dosage['dos_id']; ?>"><?php echo $dosage['dos_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<span class="add" onclick="model_show('business_edit_pwd')">+</span>
						</td>
					</tr>
					<tr>
						<td>分类：</td>
						<td>
							<select name="category">
								<option value="0">请选择...</option>	
								<?php if(is_array($categorys) || $categorys instanceof \think\Collection || $categorys instanceof \think\Paginator): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?>
								<option value="<?php echo $category['cat_id']; ?>"><?php echo $category['cat_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<!-- <span class="add" onclick="model_show('add_category_model')">+</span> -->
						</td>
					</tr>
					<tr>
						<td>运费：</td>
						<td>
							<input type="radio" value="1" name="freight" checked="checked" />有运费
							<input type="radio" value="0" name="freight" />包邮
						</td>
					</tr>
					<tr>
						<td>是否热卖：</td>
						<td>
							<input type="radio" value="1" name="is_hot" />是
							<input type="radio" value="0" name="is_hot" checked="checked" />否
							
						</td>
					</tr>
					<tr>
						<td>是否推荐：</td>
						<td>
							<input type="radio" value="1" name="is_recommend" />是
							<input type="radio" value="0" name="is_recommend" checked="checked" />否
							
						</td>
					</tr>
					<tr>
						<td>是否上架：</td>
						<td>
							<input type="radio" value="1" name="is_onsale" checked="checked" />是
							<input type="radio" value="0" name="is_onsale" />否
							
						</td>
					</tr>
					<tr>
						<td>售后说明：</td>
						<td>
							<textarea name="after_sale"></textarea>
						</td>
					</tr>
					<tr>
						<td>商品图片：<br/><span class="tipp">（请上传1~5张图片）</span></td>
						<td><input type="file" name="img[]" /> <span class="add" onclick="imgFileAdd(this)">+</span></td>
					</tr>
				</table>
			</div>
			<div class="attr_fei">
				<table>
					<tr>
						<td>品牌：</td>
						<td><input type="text" name="brand" /></td>
					</tr>
					<tr>
						<td>生产商：</td>
						<td><input type="text" name="producer" /></td>
					</tr>
					<tr>
						<td>批准文号：</td>
						<td><input type="text" name="approval_number" /></td>
					</tr>
					<tr>
						<td>储藏方式：</td>
						<td><input type="text" placeholder="密封" name="deposit" /></td>
					</tr>
					<tr>
						<td>功效：</td>
						<td><textarea name="effect"></textarea></td>
					</tr>
					<tr>
						<td>禁忌：</td>
						<td><textarea name="taboo"></textarea></td>
					</tr>
					<tr>
						<td colspan="2" class="submit">
							<button onclick="return form_submit('add_product')" class="sub_but">提交</button>
						</td>
					</tr>
				</table>
			</div>
		</form>
		</div>
	</div>

	<script>
		$(function(){
			$(".product_main .product_attr .attr_gong").show();
			$(".product_main .product_attr .attr_fei").hide();

			$(".product_main .title div").click(function(){
				$(".product_main .title div").removeClass('on');
				$(this).addClass('on');
				if($(this).attr('attr')=='attr_gong'){
					$(".product_main .product_attr .attr_gong").show();
					$(".product_main .product_attr .attr_fei").hide();
				}else{
					$(".product_main .product_attr .attr_gong").hide();
					$(".product_main .product_attr .attr_fei").show();
				}
			});
		});

		//点击添加图片input
		function imgFileAdd(the){
			var imgs_count = $(".product_main [name='img[]']").length;
			if(imgs_count>4){
				$(the).hide();
				return;
			}
			var str = "<tr><td>&nbsp;</td><td><input type='file' name='img[]' /></td></tr>";
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
