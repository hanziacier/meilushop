<?php /*a:4:{s:61:"/data/wwwroot/yershop/application/admin/view/order/index.html";i:1546778312;s:63:"/data/wwwroot/yershop/application/admin/view/public/header.html";i:1531675504;s:63:"/data/wwwroot/yershop/application/admin/view/public/dialog.html";i:1520503620;s:63:"/data/wwwroot/yershop/application/admin/view/public/footer.html";i:1531675686;}*/ ?>
 <!-- 头部 -->
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title><?php echo htmlentities((isset($meta_title) && ($meta_title !== '')?$meta_title:"")); ?>|yershop后台管理</title>
   
	<link rel="stylesheet" href="/public/admin/css/style.css" />
	<script type="text/javascript" src="/public/common/jquery.min.js" ></script>
   <script type="text/javascript" src="/public/common/layer/layer.js"></script>

	<!-- 自定义弹窗-->
    <script>
	var dialog_style ="<?php echo C('DIALOG_STYLE'); ?>";
	var index_url="<?php echo url('index/index'); ?>";
	$(".logo").click(function(){
	   location.href=index_url;
	});
</script>
  <!--引入改进型easydialog弹窗 -->	
<?php if(C('DIALOG_STYLE') == '1'): ?>	
	<link rel="stylesheet" href="/public/admin/css/global.css">
	<link rel="stylesheet" href="/public/admin/css/animate.css">
	<link rel="stylesheet" href="/public/admin/css/dialog.css">
	<style>
		.div-testDialog{
			width: 500px;
			height: auto;
			margin: 50px auto;
		}

		.div-testDialog button{
			margin:  10px;
		}
		@media screen and ( max-width: 460px){
			.div-testDialog{
				width: 90%;
			}
		}
   </style>
<script src="/public/admin/js/dialog.js"></script>	
<?php endif; ?>
	
	</head>
	<body>
		<div class="top header">
			<div class="logo"></div>
			<ul class="main_links">
		           	<li><a href="<?php echo url('index/index'); ?>" >首页 </a></li>
					<?php if(isset($group)): ?>    
                        <!-- 欢迎语 -->
						   <?php if(is_array($group) || $group instanceof \think\Collection || $group instanceof \think\Paginator): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <li><a href="<?php echo htmlentities(get_group_url($vo['id'])); ?>"><?php echo htmlentities((isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:"")); ?> </a>
							
							</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>  
							
			  <li><a href="<?php echo site_url(); ?>" target="_blank">前台</a></li>
                <?php endif; ?>
			</ul>	
			<div class="user_info">
			
				<a href="<?php echo url('login/logout'); ?>" id="user_icon"><i class="fa fa-user"></i></a>
				
			</div>
			<div class="down_menu" id="down_menu">
				<ul>
				<li><a href="<?php echo url('ucenter/edit',array('id'=>is_login())); ?>">修改资料</a></li>
				<li><a href="<?php echo url('login/logout'); ?>">退出登录</a></li>
				</ul>
			</div>
		<script>	
		
	</script>	

		</div>
	    <div class="main">
			<div class="nav_tree" style="">
				<div class="innerUl"><?php if(is_array($sidebar) || $sidebar instanceof \think\Collection || $sidebar instanceof \think\Paginator): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> 
<li><a id="<?php echo htmlentities($vo['id']); ?>" href="<?php echo htmlentities($vo['url']); ?>"><?php echo htmlentities($vo['title']); ?></a>

<ul class="menuUl"><?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><li><a id="<?php echo htmlentities($vo1['id']); ?>" href="<?php echo htmlentities($vo1['url']); ?>"><?php echo htmlentities($vo1['title']); ?></a>

<ul class="menuUl"><?php if(is_array($vo1['child']) || $vo1['child'] instanceof \think\Collection || $vo1['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo1['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><li><a id="<?php echo htmlentities($vo2['id']); ?>"href="<?php echo htmlentities($vo2['url']); ?>"><?php echo htmlentities($vo2['title']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

</ul></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></li>

<?php endforeach; endif; else: echo "" ;endif; ?>
		         </div>
	    </div>
		
	     <script type="text/javascript">
		    var oDiv3 = document.getElementById('user_icon');
			var oDiv4 = document.getElementById('down_menu');
			var timer2 = null;
			oDiv3.onmouseover = oDiv4.onmouseover = function (){	
				oDiv4.style.display = 'block';
				clearTimeout(timer2);
			}
			oDiv3.onmouseout = oDiv4.onmouseout = function (){
				//寮€瀹氭椂鍣�
				timer2 = setTimeout(function () { 
				oDiv4.style.display = 'none'; },300);
			}
		  
		    var upload_url = "<?php echo url('uploads/picture'); ?>";
		    var oss_path = "/public/common/plupload";
			var site_path = "<?php echo site_url(''); ?>";
		    var upload_type="<?php echo C('upload_type'); ?>";
			var get_url= "<?php echo url('Attachment/get'); ?>";
			if(upload_type==1){
				 var domain_url = "<?php echo C('SERVERURL'); ?>";
			}else{    
			  var domain_url = "<?php echo url('Attachment/update'); ?>";
			}
	        var insert_url = "<?php echo url('Attachment/insert'); ?>";
       </script>			
 	   <script type="text/javascript" src="/public/common/plupload/lib/plupload-2.1.2/js/plupload.full.min.js"></script>    
                                   <script type="text/javascript" src="/public/common/plupload/upload.js"></script> 
								   <script type="text/javascript" src="/public/common/laydate/laydate.js"></script> 
<!-- 头部 --> 
	
			<div class="content">
				<div class="tips_msg none"><span class="tips">保存成功</span><span class="close_tips"></span></div>
				<div class="edit_title"><?php echo htmlentities((isset($meta_title) && ($meta_title !== '')?$meta_title:"")); ?></div>
					 <script type="text/javascript" src="/public/common/laydate/laydate.js"></script>	
					 <div class="search">
					   <form class="search-form"  action="<?php echo url(); ?>" method="post">
						  <div class="group">
							  收件人：<input type="text" name="username" class="search_ipt" value="<?php echo input('username'); ?>"/>
						  </div> 
						  <div class="group">
							  用户uid：<input type="text" name="uid" class="search_ipt" value="<?php echo input('uid'); ?>"/>
						  </div>
							  <div class="group">
							订单号：<input type="text" name="order_sn"  class="search_ipt" value="<?php echo input('order_sn'); ?>"/>
						  </div>
							 <div class="group">
							 创建时间：<input type="text"  name="start_time" id="start_time" class="laydate-icon input_box search_ipt" value="<?php echo input('start_time'); ?>"/> 
						  </div>
						
						 <div class="group">
							 结束时间：<input type="text"  name="end_time" id="end_time" class="laydate-icon input_box search_ipt" value="<?php echo input('end_time'); ?>"/>
						  </div>
						
						   <div class="group">
							   手机：<input type="text" name="mobile" class="search_ipt" value="<?php echo input('monile'); ?>"/>
						  
						  </div>  
						  <div class="group">
						   订单类型:
								<select name="order_type"  class=" input_box search_ipt" >
								<option value="0">普通订单</option>   
								<option value="1">积分订单</option>   
								<option value="2">拼团订单</option>   
								</select>
						  </div>
						  <div class="group">
						   订单状态:
								<select name="status"  class=" input_box search_ipt" >
								<option value="0">待支付</option>   
								<option value="1">待发货</option>   
								<option value="2">已发货</option> 
								<option value="3">已确认</option>   	 
								</select> <input type="button" class="search_btn"value="搜索" onclick="$('.search-form').submit()">
						  </div>
							
							  
							 
					</form>
				</div>
				<div class="table">
					<div class="edit">
						<div class="edit_left ">
							<a href="<?php echo url('add'); ?>" class="add cur">新增</a>
							<a data-url="<?php echo url('del'); ?>" class="delete cur">删除</a>
							<a href="<?php echo url('out'); ?>" class="add cur blue">导出</a>
						</div>
						<div class="search_right">
							<input type="text" value="<?php echo input('title'); ?>"/>
							<div class="search_btn"></div>
						</div>
					</div>

						<div class="sle_all f12">
							<label for="">
								<input type="checkbox" class="checkbox check-all"/>
								<span class="date">全选</span>
								<a  data-url="<?php echo url('send'); ?>" class="send_order pl">批量发货</a>
								<a  data-url="<?php echo url('confirm'); ?>"  class="confirm_order pl">批量确认收货</a>
							</label>
							
						</div>						
			     
						<div class="bought_list f12">
						  <table class="del_table ">
								<tbody>
									<tr>
										<td class="td_01">
											
											<div class="con">
												<div class="div_01 fl">
													商品名称
												</div>
												<div class="div_02 fl">
													
													单价
												</div>
											<div class="div_03 fl">
													
													数量
												</div>
												<div class="div_04 fl">
										         金额
												</div>
											</div>
																					
										</td>	
										<td class="td_02">
										    总数量
										</td>									
										<td class="td_02">
										    总金额
										</td>
										<td class="td_03">
										  状态	
										</td>
										<td class="td_04">
	                                              操作
										</td>
									</tr>
								</tbody>
							</table>
							<?php if(!(empty($res['list']) || (($res['list'] instanceof \think\Collection || $res['list'] instanceof \think\Paginator ) && $res['list']->isEmpty()))): if(is_array($res['list']) || $res['list'] instanceof \think\Collection || $res['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $res['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							<table class="top_table">
								<tbody>
									<tr>
										<td class="td_01">
											<input  class="ids row-selected" type="checkbox" name="id[]" value="<?php echo htmlentities($vo['id']); ?>" />
											<span class="date">下单时间<?php echo htmlentities(date('Y-m-d H:i',!is_numeric($vo['create_time'])? strtotime($vo['create_time']) : $vo['create_time'])); ?></span>
											<span class="dd_nm">订单号: <?php echo htmlentities($vo['order_sn']); ?></span>
										</td>
										<td class="td_02">
										
										</td>
										<td class="td_03">
										
										</td>
										<td class="td_04">
										<?php if($vo['status'] > 2): ?><a onclick="delOrder(<?php echo htmlentities($vo['id']); ?>)"></a><?php endif; ?>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="del_table ">
								<tbody>
									<tr>
										<td class="td_01">
											<?php if(is_array($vo['sales']) || $vo['sales'] instanceof \think\Collection || $vo['sales'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['sales'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
											<div class="con">
												<div class="div_01 fl">
													<span class="pic fl" target="_blank" ><img src="<?php echo htmlentities(get_goods_cover($vo1['goods_id'])); ?>"></span>
													<div class="info fl">
														<span target="_blank" class="name"><?php echo htmlentities($vo1['title']); ?></span>
														<p class="color">规格：<?php echo htmlentities($vo1['specifications']); ?></p>
														<span class="icon"></span>
													</div>
												</div>
												<div class="div_02 fl">
													
													<p class="new">￥<?php echo htmlentities($vo1['price']); ?></p>
												</div>
												<div class="div_03 fl">
													<p class="new"><?php echo htmlentities($vo1['num']); ?></p>
												</div>
												<div class="div_04 fl">
										        <p class="new">  <?php echo htmlentities($vo1['total']); ?></p>
												</div>
											</div>
											<?php endforeach; endif; else: echo "" ;endif; ?>										
										</td>	
										<td class="td_02">
											<?php echo htmlentities((isset($vo['num']) && ($vo['num'] !== '')?$vo['num']:"")); ?>
											
										</td>										
										<td class="td_02">
											<p class="total price">
											<?php if($vo['order_type'] == 1): ?><?php echo htmlentities($vo['total_money']); ?>积分<?php endif; if($vo['order_type'] == 0): ?>￥<?php echo htmlentities($vo['total_money']); ?><?php endif; if($vo['order_type'] == 2): ?>￥<?php echo htmlentities($vo['total_money']); ?><?php endif; ?>
											</p>
											<p class="yf">(含运费：￥<?php echo htmlentities((isset($vo['spress']) && ($vo['spress'] !== '')?$vo['spress']:"0")); ?>)</p>
											<?php if($vo['type'] == 1): ?><div class="phone">手机订单</div><?php endif; ?>
										</td>
										<td class="td_03">
										<a  class="green">	
										    <?php if($vo['status'] == -1): ?>无效订单<?php endif; if($vo['status'] == 0): ?>待支付<?php endif; if($vo['status'] == 1): ?>待发货<?php endif; if($vo['status'] == 2): ?>已发货<?php endif; if($vo['status'] == 3): ?>已确认<?php endif; if($vo['status'] == 4): ?>申请取消中<?php endif; if($vo['status'] == 5): ?>取消订单被拒绝<?php endif; if($vo['status'] == 6): ?>订单已取消<?php endif; ?>
										</a>
										</td>
										<td class="td_04">
										  <a href="<?php echo url('edit?id='.$vo['id']); ?>" class="edit_btn ddxq">编辑</a>
										 
										  <a href="<?php echo url('detail?id='.$vo['id']); ?>" class="ddxq">详情</a>
											
										</td></tr>
										
								</tbody>
							</table>
							<table class="del_table "><tr> 收件人：<?php echo htmlentities($vo['username']); ?>  地址：<?php echo htmlentities($vo['address']); ?> 联系方式：<?php echo htmlentities($vo['mobile']); ?>
									</tr></tbody>
							</table>
						<?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
						    <div class="sle_all_01 f12">
							
							
						</div>
						<?php else: ?>
						    <span style="text-align:center;width:100%;display:block;">无数据！</span>
						<?php endif; ?>
						<div class="page_div page">
							  <?php echo $res['page']; ?>
							
						</div>	
					
				</div>
			
			</div>
		</div>
	   <script src="/public/admin/js/style.js"></script> 
       <script>
	       $("select[name='status']").val("<?php echo input('status'); ?>");
	       $("select[name='isdao']").val("<?php echo input('isdao'); ?>");
				laydate({
					  elem: '#end_time',
					  format: 'YYYY-MM-DD hh:mm:ss', 
					  min: laydate.now(), //设定最小日期为当前日期//目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
					  event: 'focus' //响应事件。如果没有传入event，则按照默认的click
				});
   
				laydate({
					elem: '#start_time',
					format: 'YYYY-MM-DD hh:mm:ss', 
					min: laydate.now(), //设定最小日期为当前日期//目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
					event: 'focus' //响应事件。如果没有传入event，则按照默认的click
				});
		</script>
	<!-- 尾部 -->
	
<script src="/public/admin/js/common.js"></script>  

<script>
var html='<footer style=""><p> Powered by <a href="http://www.yershop.com/" target="_blank">yershop V3.0</a> </p></footer>';

$(".content").append(html);
var sid="<?php echo input('module_id')?input('module_id'):$now['id']; ?>";var obj=$("a#"+sid);$(obj).parents("li").eq(0).addClass("active");
</script>
</body>
</html>
    <!-- 尾部 --> 
