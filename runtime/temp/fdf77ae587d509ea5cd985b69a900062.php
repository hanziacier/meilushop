<?php /*a:2:{s:61:"/data/wwwroot/yershop/application/admin/view/index/index.html";i:1547548023;s:63:"/data/wwwroot/yershop/application/admin/view/public/dialog.html";i:1520503620;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo htmlentities((isset($meta_title) && ($meta_title !== '')?$meta_title:"")); ?>|yershop后台管理</title>
		<link rel="stylesheet" href="/public/admin/css/style.css" />
	    <link rel="stylesheet" href="/public/common/font-awesome/css/font-awesome.min.css">
		<script type="text/javascript" src="/public/admin/js/jquery.min.js" ></script>
	</head>

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

	<body>
		<div class="top"  style="margin:0 auto;">
			<div class="logo"></div>
			<ul class="main_links">
			<li><a href="<?php echo url('index/index'); ?>">首页 </a></li>  <?php if(isset($group)): ?>    
                        <!-- 欢迎语 -->
						   <?php if(is_array($group) || $group instanceof \think\Collection || $group instanceof \think\Paginator): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <li><a href="<?php echo htmlentities(get_group_url($vo['id'])); ?>"><?php echo htmlentities((isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:"")); ?> </a></li>
							<?php endforeach; endif; else: echo "" ;endif; ?>  
							<?php endif; ?>
			<li><a href="<?php echo site_url(); ?>" target="_blank">前台 </a></li>

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
	</script>	

		</div>
	<div class="blocks" >
			
	<div class="warp">
			<div class="bg"></div>
				<div class="show_info">
					<div class="calc_goods_cate show_info_div left">
						<div class="left_img">
							<div></div>
						</div>
						<div class="right_text category">
							<span class="text_title">总分类数</span>
							<span class="num"><?php echo htmlentities((isset($info['category']) && ($info['category'] !== '')?$info['category']:"0")); ?></span>
						</div>
					</div>
					
					  <div class="imgs_tnums show_info_div left">
						<div class="left_img">
							<div></div>
						</div>
						<div class="right_text pics">
							<span class="text_title">总图片数</span>
							<span class="num"><?php echo htmlentities((isset($info['category']) && ($info['category'] !== '')?$info['category']:"0")); ?></span>
						</div>
					</div>
					
					<div class="ads_nums show_info_div left">
						<div class="left_img">
							<div></div>
						</div>
						<div class="right_text ad">
							<span class="text_title">广告个数</span>
							<span class="num"><?php echo htmlentities((isset($info['ad']) && ($info['ad'] !== '')?$info['ad']:"0")); ?></span>
						</div>
					</div>
					<div class="goods_quantity show_info_div left">
						<div class="left_img">
							<div></div>
						</div>
						<div class="right_text log">
							<span class="text_title">日志个数</span>
							<span class="num"><?php echo htmlentities((isset($info['log']) && ($info['log'] !== '')?$info['log']:"0")); ?></span>
						</div>
					</div>
					<div class="user_amount show_info_div left">
						<div class="left_img">
							<div></div>
						</div>
						<div class="right_text user">
							<span class="text_title">用户量</span>
							<span class="num"><?php echo htmlentities((isset($info['user']) && ($info['user'] !== '')?$info['user']:"0")); ?></span>
						</div>
					</div>
				</div>
			  
				 
			</div>
		</div>
		
		
			<div class="container"> 

	<div class="item">

		
			<div class="tit computer"><img class="icon-computer" src="/public/admin/images/com.png">系统信息</div>
			
							<table>
					<tbody>
					
					<tr>
						<th>thinkphp版本</th>
						<td><?php echo htmlentities(app()->version()); ?>
							
						</td>
				
					</tr><tr>
						<th>服务器操作系统</th>
						<td><?php echo htmlentities(PHP_OS); ?></td>
					</tr>
					
					<tr>
						<th>服务器解译引擎</th>
						<td><?php echo htmlentities($_SERVER['SERVER_SOFTWARE']); ?></td>
					</tr>
					<tr>
						<th>应用部署目录 </th>
												<td><?php echo getcwd(); ?></td>
					</tr>
					<tr>
						<th>上传限制</th>
						<td><?php echo ini_get('upload_max_filesize'); ?></td>
					</tr>
					
				</tbody></table>
	
</div>
<!--<div class="item">
			<div class="tit soft"><img class="icon-soft" src="/public/admin/images/soft.png">软件信息</div>
				<table>
					<tbody>
					<tr>
						<th>软件名称</th>
						<td>yershop网店管理系统</td>
					</tr>
					
					
					<tr>
						<th>官方网址</th>
						<td><a href="http://www.yershop.com" target="_blank">yershop.com</a></td>
					</tr>
					<tr>
						<th>商业授权</th>
						<td><a href="http://www.yershop.com/index/index/price.html" target="_blank">授权</a></td>
					</tr>
					<tr>
						<th>版权所有</th>
						<td>武汉贝云网络科技有限公司</td>
					</tr>
					<tr>
						<th>使用帮助</th>
						<td><a href="http://wpa.qq.com/msgrd?v=3&uin=1010422715&site=qq&menu=yes" target="_blank">技术支持</a></td>
					</tr>
				</tbody></table>
			</div>-->

	</div>
<!--<div class="footer"><p> Powered by <a href="http://www.yershop.com/" style="color:blue" target="_blank">yershop</a>@2014-2018武汉贝云网络科技有限公司 </p></div>
-->
