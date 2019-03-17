<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"D:\phpStudy\WWW\yao_store\public/../application/admin\view\product\editproduct.html";i:1515675224;s:60:"D:\phpStudy\WWW\yao_store\application\admin\view\layout.html";i:1515763734;}*/ ?>
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
  
		
	<div class="editProduct_main">
		<div class="editProduct_title">
			<span>商品详情</span>
			<span><a href="<?php echo url('Product/product'); ?>">返回>></a></span>
		</div>
		<form action="<?php echo url('Product/editProductSubmit'); ?>" method="post" name="edit_product" enctype="multipart/form-data">
		<input type="hidden" name="pro_id" value="<?php echo $proId; ?>">
		<!-- 商品图片 -->
		<div class="editProduct_imgs">
			<div class="title">
				<span>商品图片</span>
			</div>
			<div class="imgs">
				<div class="set_topic_img">
					设置商品主图：
				</div>
				<div class="product_img">
					<?php if(is_array($imgInfo) || $imgInfo instanceof \think\Collection || $imgInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $imgInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$imgs): $mod = ($i % 2 );++$i;?>
					<div class="img_item">
						<span><input type="radio" name="topic_img" <?php if($imgs['ima_id'] == $proInfo['main_img_id']): ?>checked="checked"<?php endif; ?> value="<?php echo $imgs['ima_id']; ?>" /></span>
						<span><img src="<?php echo $imgs['ima_url']; ?>" /> <a href="<?php echo url('Product/delProImgByImgId',array('img_id'=>$imgs['ima_id'],'pro_id'=>$proId)); ?>" onclick="return confirm('您确定要删除此商品图片吗？');" ><img src="/static/images/cancel.png" class="del_img" /></a></span>
					</div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
		</div>
		<!-- 商品属性 -->
		<div class="editProduct_attr">
			<div class="public_attr">
				<div class="title">
					共有属性
				</div>
				<div class="main">
					<table>
						<tr>
							<td>商品名：</td>
							<td><input type="text" value="<?php echo $proInfo['pro_name']; ?>" name="name" /></td>
						</tr>
						<tr>
							<td>规格：</td>
							<td><input type="text" value="<?php echo $proInfo['pro_specification']; ?>" name="specification" /></td>
						</tr>
						<tr>
							<td>价格：</td>
							<td><input type="text" value="<?php echo $proInfo['pro_price']; ?>" name="price" /></td>
						</tr>
						<tr>
							<td>库存：</td>
							<td>
								<span class="stock"><?php echo $proInfo['pro_stock']; ?></span><span class="contro_stock" onclick="editStock(this,'add')">添加</span><span class="contro_stock" onclick="editStock(this,'del')">减少</span>
							</td>
						</tr>
						<tr>
							<td>剂型：</td>
							<td>
								<select name="dosage">
									<?php if(is_array($dosInfo) || $dosInfo instanceof \think\Collection || $dosInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $dosInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dos): $mod = ($i % 2 );++$i;?>
									<option value="<?php echo $dos['dos_id']; ?>" <?php if($dos['dos_id'] == $proInfo['dosage_id']): ?>selected<?php endif; ?>><?php echo $dos['dos_name']; ?></option>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>分类：</td>
							<td>
								<select name="category">
									<?php if(is_array($catInfo) || $catInfo instanceof \think\Collection || $catInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $catInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?>
									<option value="<?php echo $cat['cat_id']; ?>" <?php if($cat['cat_id'] == $proInfo['category_id']): ?>selected<?php endif; ?>><?php echo $cat['cat_name']; ?></option>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>运费：</td>
							<td>
								<input type="radio" name="freight" value="1" <?php if($proInfo['pro_postage'] == 1): ?>checked='checked'<?php endif; ?> />有运费
								<input type="radio" name="freight" value="0" <?php if($proInfo['pro_postage'] == 0): ?>checked='checked'<?php endif; ?> />包邮
							</td>
						</tr>
						<tr>
							<td>是否热卖：</td>
							<td>
								<input type="radio" name="is_hot" value="1" <?php if($proInfo['pro_is_hot'] == 1): ?>checked='checked'<?php endif; ?> />是
								<input type="radio" name="is_hot" value="0" <?php if($proInfo['pro_is_hot'] == 0): ?>checked='checked'<?php endif; ?> />否
							</td>
						</tr>
						<tr>
							<td>是否推荐：</td>
							<td>
								<input type="radio" name="is_recommend" value="1" <?php if($proInfo['pro_is_recommend'] == 1): ?>checked='checked'<?php endif; ?>  />是
								<input type="radio" name="is_recommend" value="0" <?php if($proInfo['pro_is_recommend'] == 0): ?>checked='checked'<?php endif; ?> />否
							</td>
						</tr>
						<tr>
							<td>是否上架：</td>
							<td>
								<input type="radio" name="is_onsale" value="1" <?php if($proInfo['pro_is_onsale'] == 1): ?>checked='checked'<?php endif; ?> />是
								<input type="radio" name="is_onsale" value="0" <?php if($proInfo['pro_is_onsale'] == 0): ?>checked='checked'<?php endif; ?> />否
							</td>
						</tr>
						<tr>
							<td>售后说明：</td>
							<td>
								<textarea name="after_sale"><?php echo $proInfo['pro_after_sale_description']; ?></textarea>
							</td>
						</tr>
						<tr>
							<td>
								添加商品图：
							</td>
							<td>
								
								<input type="file" name="imgs[]" />	<span class="add_img" onclick="addImgs(this)">增加</span>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="other_attr">
				<div class="title">
					非必须属性
				</div>
				<div class="main">
					<table>
						<tr>
							<td>品牌：</td>
							<td><input type="text" name="brand" value="<?php echo $proInfo['pro_brand']; ?>" /></td>
						</tr>
						<tr>
							<td>生产商：</td>
							<td><input type="text" name="producer" value="<?php echo $proInfo['pro_producer']; ?>" /></td>
						</tr>
						<tr>
							<td>批准文号：</td>
							<td><input type="text" name="approval_number" value="<?php echo $proInfo['pro_approval_number']; ?>" /></td>
						</tr>
						<tr>
							<td>储藏方式：</td>
							<td><input type="text" name="deposit" value="<?php echo $proInfo['pro_deposit']; ?>" /></td>
						</tr>
						<tr>
							<td>功效：</td>
							<td><textarea name="effect"><?php echo $proInfo['pro_effect']; ?></textarea></td>
						</tr>
						<tr>
							<td>禁忌：</td>
							<td><textarea name="taboo"><?php echo $proInfo['pro_taboo']; ?></textarea></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="edit_pro_tip">
			<span>注：每件商品最多上传5张商品图，超出的则不会上传成功。</span>
		</div>
		<!-- 提交按钮 -->
		<div class="submitBtn">
			<button class="sub_but" onclick="return editProSubmit('edit_product')">修改提交</button>
		</div>
		</form>
	</div>

	<script>
		$(function(){
			setDivHeight();
		});

		/*
		** 设置非必须属性 div与共有属性一样高
		*/
		function setDivHeight(){
			var pub_Width = $(".editProduct_main .public_attr .main").height();
			$(".editProduct_main .other_attr .main").height(pub_Width);
		}

		/*
		 * 点击 增加、减少 库存效果
		 */
		function editStock(the,str){
			//添加on样式
			$('.editProduct_main .contro_stock').removeClass('on');
			$(the).addClass('on');

			//增加库存
			if (str=='add') {			
				//删除减少库存节点
				$(".editProduct_main .del_node").remove();

				var addNode = "<tr class='add_node'><td>&nbsp;</td><td><input type='number' name='add_stock' placeholder=' 增加库存' /></td></tr>";
				$(the).parent().parent().after(addNode);
			}

			//减少库存
			if (str=='del') {
				//删除减少库存节点
				$(".editProduct_main .add_node").remove();

				var delNode = "<tr class='del_node'><td>&nbsp;</td><td><input type='number' name='del_stock' placeholder=' 减少库存' /></td></tr>";
				$(the).parent().parent().after(delNode);
			}

			setDivHeight();
		}

		/*
		 * 点击增加 图片效果
		 */
		function addImgs(the){
			var imgs_count = $(".editProduct_main [name='imgs[]']").length;
			if(imgs_count>4){
				$(the).hide();
				return;
			}
			var str = "<tr><td>&nbsp;</td><td><input type='file' name='imgs[]' /></td></tr>";
			$(the).parent().parent().after(str);

			setDivHeight();
		}

		//检查填写的商品信息
		function editProSubmit(form_name){
			if(!confirm('您确定编辑完商品，要提交吗？')){
				return false;
			}

			var name = $(".editProduct_main .editProduct_attr [name='name']").val(),	//商品名
				specification = $(".editProduct_main .editProduct_attr [name='specification']").val(),	//规格
				price = $(".editProduct_main .editProduct_attr [name='price']").val(),	//价格
				after_sale = $(".editProduct_main .editProduct_attr [name='after_sale']").val();  //售后说明

			if(name==""){
				alert("商品名不能为空");
				return false;
			}
			if(specification==""){
				alert("商品规格不能为空");
				return false;
			}

			//正则匹配价格 库存
			var reg = /^[0-9]+[.]?[0-9]*$/;
			var after_price = price.match(reg);
			if(after_price==null || price==0){
				alert("商品价格必须是大于0的数字");
				return false;
			}

			if(after_sale==""){
				alert("请填写售后说明");
				return false;
			}

			//鼠标失去事件，避免多次点击
			$(".editProduct_main .submitBtn .sub_but").addClass('pointer_event');
			//$(".product_main .product_attr .attr_fei .sub_but").text('正在上传...');
			submit_form(form_name);
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
