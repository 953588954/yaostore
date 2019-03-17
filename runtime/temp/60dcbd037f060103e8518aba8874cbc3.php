<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\product\product.html";i:1516187497;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1519553941;}*/ ?>
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
  
		
	<div class="products_main">
		<!-- 筛选条件title -->
		<div class="condition_title">
			<span style="font-size: 15px;font-weight: bold;">商品筛选</span>
			<span style="font-size: 14px;">共 <font color="red"><?php echo $count; ?></font>个商品</span>
		</div>
		<!--end 筛选条件title -->

		<!-- 筛选条件 -->
		<div class="conditions">
				<!-- 分类条件 -->
				<div class="condition_item">
					<div class="con_title">分类</div>
					<div class="con_main">
						<span class="con_main_item <?php if($param['category'] == 0): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>0,'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>">全部</a></span>
						<?php if(is_array($categorys) || $categorys instanceof \think\Collection || $categorys instanceof \think\Paginator): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?>
						<span class="con_main_item <?php if($param['category'] == $category['cat_id']): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$category['cat_id'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>"><?php echo $category['cat_name']; ?></a></span>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					
				</div>
				<!-- 剂型 -->
				<div class="condition_item">
					<div class="con_title">剂型</div>
					<div class="con_main">
						<span class="con_main_item <?php if($param['dosage'] == 0): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>0,'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>">全部</a></span>
						<?php if(is_array($dosages) || $dosages instanceof \think\Collection || $dosages instanceof \think\Paginator): $i = 0; $__LIST__ = $dosages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dosage): $mod = ($i % 2 );++$i;?>
						<span class="con_main_item <?php if($param['dosage'] == $dosage['dos_id']): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$dosage['dos_id'],'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>"><?php echo $dosage['dos_name']; ?></a></span>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</div>	
				</div>
				<!-- 是否免邮 -->
				<div class="condition_item">
					<div class="con_title">是否包邮</div>
					<div class="con_main">
						<span class="con_main_item <?php if($param['postage'] == 3): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>3,'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>">全部</a></span>
						<span class="con_main_item <?php if($param['postage'] == 0): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>0,'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>">是</a></span>
						<span class="con_main_item <?php if($param['postage'] == 1): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>1,'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>">否</a></span>
					</div>	
				</div>
				<!-- 是否热卖 -->
				<div class="condition_item">
					<div class="con_title">是否热卖</div>
					<div class="con_main">
						<span class="con_main_item <?php if($param['is_hot'] == 3): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>3,'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>">全部</a></span>
						<span class="con_main_item <?php if($param['is_hot'] == 1): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>1,'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>">是</a></span>
						<span class="con_main_item <?php if($param['is_hot'] == 0): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>0,'is_recommend'=>$param['is_recommend'],'is_onsale'=>$param['is_onsale'])); ?>">否</a></span>
					</div>	
				</div>
				<!-- 是否推荐 -->
				<div class="condition_item">
					<div class="con_title">是否推荐</div>
					<div class="con_main">
						<span class="con_main_item <?php if($param['is_recommend'] == 3): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>3,'is_onsale'=>$param['is_onsale'])); ?>">全部</a></span>
						<span class="con_main_item <?php if($param['is_recommend'] == 1): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>1,'is_onsale'=>$param['is_onsale'])); ?>">是</a></span>
						<span class="con_main_item <?php if($param['is_recommend'] == 0): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>0,'is_onsale'=>$param['is_onsale'])); ?>">否</a></span>
					</div>	
				</div>
				<!-- 是否上架 -->
				<div class="condition_item">
					<div class="con_title">是否上架</div>
					<div class="con_main">
						<span class="con_main_item <?php if($param['is_onsale'] == 3): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>3)); ?>">全部</a></span>
						<span class="con_main_item <?php if($param['is_onsale'] == 1): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>1)); ?>">是</a></span>
						<span class="con_main_item <?php if($param['is_onsale'] == 0): ?>on<?php endif; ?>"><a href="<?php echo url('Product/product',array('category'=>$param['category'],'dosage'=>$param['dosage'],'postage'=>$param['postage'],'is_hot'=>$param['is_hot'],'is_recommend'=>$param['is_recommend'],'is_onsale'=>0)); ?>">否</a></span>
					</div>	
				</div>
				
		</div>
		<!--end 筛选条件 -->

		<!-- 商品内容 -->
		<div class="products">
			<div class="product_title">
				<span>序号</span>
				<span>商品名</span>
				<span>商品主图</span>
				<span>价格</span>
				<span>库存</span>
				<span>分类</span>
				<span>是否免邮</span>
				<span>是否热卖</span>
				<span>是否推荐</span>
				<span>操作</span>
			</div>
			<?php if(is_array($products) || $products instanceof \think\Collection || $products instanceof \think\Paginator): $i = 0; $__LIST__ = $products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$product): $mod = ($i % 2 );++$i;?>
			<div class="product_data">
				<span><?php echo $i; ?></span>
				<span><?php echo $product['pro_name']; ?></span>
				<span><img src="<?php echo $product['mainImg']['ima_url']; ?>" /></span>
				<span><?php echo $product['pro_price']; ?></span>
				<span><?php echo $product['pro_stock']; ?></span>
				<span><?php echo $product['cate']['cat_name']; ?></span>
				<span><?php if($product['pro_postage'] == 0): ?>✔<?php else: ?>✘<?php endif; ?></span>
				<span><?php if($product['pro_is_hot'] == 1): ?>✔<?php else: ?>✘<?php endif; ?></span>
				<span><?php if($product['pro_is_recommend'] == 1): ?>✔<?php else: ?>✘<?php endif; ?></span>
				<span><a href="<?php echo url('Product/editProduct',array('pro_id'=>$product['pro_id'])); ?>" class="detail_a">查看详情</a></span>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			
			<!-- 分页 -->
			<div class="page">
				<?php echo $page; ?>
			</div>
		</div>
		
		<!--end 商品内容 -->
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
