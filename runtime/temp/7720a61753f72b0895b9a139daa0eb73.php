<?php /*a:4:{s:60:"/data/wwwroot/yershop/application/admin/view/tree/index.html";i:1531941644;s:63:"/data/wwwroot/yershop/application/admin/view/public/header.html";i:1531675504;s:63:"/data/wwwroot/yershop/application/admin/view/public/dialog.html";i:1520503620;s:63:"/data/wwwroot/yershop/application/admin/view/public/footer.html";i:1531675686;}*/ ?>
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
		 <script type="text/javascript" src="/public/common/laydate/laydate.js"></script>	
			<div class="content" >
			         <div class="edit_title"><?php echo htmlentities((isset($meta_title) && ($meta_title !== '')?$meta_title:"")); ?></div>
					<div class="tree" style="padding:30px;"> <?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
												<p><?php echo htmlentities($vo['id']); ?>-<?php echo htmlentities((isset($vo['html']) && ($vo['html'] !== '')?$vo['html']:"")); ?><?php echo htmlentities($vo['username']); ?></pn>
											  <?php endforeach; endif; else: echo "" ;endif; ?></div>
				</div>
			</div>
		</div>
  <script src="/public/admin/js/style.js"></script>
  <script>
		laydate({
				elem: '#start_time',
				format: 'YYYY-MM-DD hh:mm:ss', 
				min: laydate.now(), //设定最小日期为当前日期//目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
				event: 'focus' //响应事件。如果没有传入event，则按照默认的click
		});
			
		laydate({
				  elem: '#end_time',
				  format: 'YYYY-MM-DD hh:mm:ss', 
				  min: laydate.now(), //设定最小日期为当前日期//目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
				  event: 'focus' //响应事件。如果没有传入event，则按照默认的click
		});
</script> <!-- 头部 -->
	
<script src="/public/admin/js/common.js"></script>  

<script>
var html='<footer style=""><p> Powered by <a href="http://www.yershop.com/" target="_blank">yershop V3.0</a> </p></footer>';

$(".content").append(html);
var sid="<?php echo input('module_id')?input('module_id'):$now['id']; ?>";var obj=$("a#"+sid);$(obj).parents("li").eq(0).addClass("active");
</script>
</body>
</html>
<!-- 头部 --> 

