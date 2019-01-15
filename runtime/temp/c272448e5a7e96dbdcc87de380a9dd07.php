<?php /*a:4:{s:63:"/data/wwwroot/yershop/application/admin/view/systems/index.html";i:1531196020;s:63:"/data/wwwroot/yershop/application/admin/view/public/header.html";i:1531675504;s:63:"/data/wwwroot/yershop/application/admin/view/public/dialog.html";i:1520503620;s:63:"/data/wwwroot/yershop/application/admin/view/public/footer.html";i:1531675686;}*/ ?>
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

  <script type="text/javascript" src="/public/common/jquery.colorpicker.js"></script>		
			<div class="content">
			<div class="tips_msg none"><span class="tips">保存成功</span><span class="close_tips"></span></div>
				<div class="edit_title"><?php echo htmlentities((isset($meta_title) && ($meta_title !== '')?$meta_title:"")); ?></div>
				<div class="edit_box">
					
					<div class="edit_tab">
				<?php if(is_array($groups) || $groups instanceof \think\Collection || $groups instanceof \think\Paginator): if( count($groups)==0 ) : echo "" ;else: foreach($groups as $key=>$vo): ?>
			      <div class="tab_option <?php if($type == $key): ?>on<?php endif; ?>"><a href="<?php echo U('?group='.$key); ?>"><?php echo htmlentities($vo); ?>配置</a></div>
		     	<?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<div class="edit_content">
							 <form class="group-form"  action="<?php echo url(''); ?>" method="post">
						   	     <div class="edit_content_tab">
									 <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$config): $mod = ($i % 2 );++$i;switch($config['type']): case "text": ?>
											    <div class="form-item">
									                 <label><?php echo htmlentities($config['title']); ?><span>(<?php echo htmlentities($config['remark']); ?>)</span></label>
													 <div class="form-input">
									                     <input type="text" name="<?php echo htmlentities($config['name']); ?>" value="<?php echo htmlentities($config['value']); ?>">
													  </div>
								                 </div>
											
											<?php break; case "string": ?>
											    <div class="form-item">
									                 <label><?php echo htmlentities($config['title']); ?><span>(<?php echo htmlentities($config['remark']); ?>)</span></label>
													 <div class="form-input">
									                     <input type="text" name="<?php echo htmlentities($config['name']); ?>" value="<?php echo htmlentities($config['value']); ?>">
													 </div>
								                 </div>
											
											<?php break; case "textarea": ?>
											   <div class="form-item">
									                 <label><?php echo htmlentities($config['title']); ?><span>(<?php echo htmlentities($config['remark']); ?>)</span></label>
													 <div class="form-input">
									                    <textarea name="<?php echo htmlentities($config['name']); ?>"/><?php echo htmlentities($config['value']); ?></textarea>
													 </div>
								                 </div>
											
											<?php break; case "radio": ?>
										         <div class="form-item">
									                 <label><?php echo htmlentities($config['title']); ?><span>(<?php echo htmlentities($config['remark']); ?>)</span></label>
													 <div class="form-input">
									                   <input type="radio" name="<?php echo htmlentities($config['name']); ?>" value="<?php echo htmlentities($config['value']); ?>"/>
													 </div>
								                 </div>
											<?php break; case "select": ?>
											    <div class="form-item">
									                 <label><?php echo htmlentities($config['title']); ?><span>(<?php echo htmlentities($config['remark']); ?>)</span></label>
													 <div class="form-input">
									                    <select name="<?php echo htmlentities($config['name']); ?>">
													        <?php $_result=parse_config_attr($config['extra']);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
													        <option value="<?php echo htmlentities($key); ?>" <?php if($config['value'] == $key): ?>selected<?php endif; ?>><?php echo htmlentities($vo); ?></option>
												             <?php endforeach; endif; else: echo "" ;endif; ?>
												        </select>
													 </div>
								                 </div>
											<?php break; case "color": ?>
											     <div class="form-item">
									                 <label><?php echo htmlentities($config['title']); ?><span>(<?php echo htmlentities($config['remark']); ?>)</span></label>
													 	<div class="form-input">
									                        <input type="text" name="<?php echo htmlentities($config['name']); ?>" value="<?php echo htmlentities($config['value']); ?>" id="<?php echo htmlentities($config['name']); ?>" style="color:<?php echo htmlentities($config['value']); ?>"/>
													  </div>
								                  </div>
												  <script>
													$("#<?php echo htmlentities($config['name']); ?>").colorpicker({
														fillcolor:true,
														success:function(o,color){
															$(o).css("color",color);
														}
													});
												 </script>
											<?php break; case "picture": ?>
										          <div class="form-item">
														<label>图片<span>(图片名称)</span></label> 
														<div id="<?php echo htmlentities($config['name']); ?>" class="container">
															<div id="file_<?php echo htmlentities($config['name']); ?>">你的浏览器不支持flash,Silverlight或者HTML5！</div>
															<input type="hidden" name="<?php echo htmlentities($config['name']); ?>"  value="<?php echo htmlentities($config['value']); ?>">
														
															<a id="select_<?php echo htmlentities($config['name']); ?>" href="javascript:void(0);" class='btn'>选择文件</a>
															<a id="post_<?php echo htmlentities($config['name']); ?>" href="javascript:void(0);" class='btn'>开始上传</a>
														</div>
				
													   <div class="uploader_preview">
															 <?php if(!(empty($config['value']) || (($config['value'] instanceof \think\Collection || $config['value'] instanceof \think\Paginator ) && $config['value']->isEmpty()))): ?>  
																  <div class="upload-pre-item"> 
																	<img class="<?php echo htmlentities($config['name']); ?>" src="<?php echo htmlentities(get_cover_path($config['value'])); ?>"/>
																	</div>
															  <?php endif; ?>
														</div>

														<script type="text/javascript">  
															var field="<?php echo htmlentities($config['name']); ?>";	var value="<?php echo htmlentities($config['value']); ?>";
															upload(field);
														</script>	
                                                  </div>
									       <?php break; case "video": ?>
											    <div class="form-item">
												      <label><?php echo htmlentities($config['title']); ?><span>(<?php echo htmlentities($config['remark']); ?>)</span></label>
												     <input type="hidden" name="<?php echo htmlentities($config['name']); ?>"  value="<?php echo htmlentities((isset($config['value']) && ($config['value'] !== '')?$config['value']:'')); ?>">
													 <div id="<?php echo htmlentities($config['name']); ?>" class="container">
														<div id="file_<?php echo htmlentities($config['name']); ?>">你的浏览器不支持flash,Silverlight或者HTML5！</div>
														<input type="hidden" name="<?php echo htmlentities($config['name']); ?>"  value="<?php echo htmlentities((isset($config['value']) && ($config['value'] !== '')?$config['value']:'')); ?>">
														<input type="text" name="file_path"  class="ipt" value="<?php echo htmlentities(get_path($config['value'])); ?>">
														<a id="select_<?php echo htmlentities($config['name']); ?>" href="javascript:void(0);" class='btn_upload'>选择文件</a>
														<a id="post_<?php echo htmlentities($config['name']); ?>" href="javascript:void(0);" class='btn_upload'>开始上传</a>
													 </div>
							
													<video src="<?php echo htmlentities(get_cover_path($config['value'])); ?>" controls="controls">
															  您的浏览器不支持 video 标签。
													</video>	
												    <script type="text/javascript">  
													var field="<?php echo htmlentities($config['name']); ?>";
													uploadVideo(field);
												   </script> 	
											  </div>
							               <?php break; case "file": ?>
											    <div class="form-item">
												     <label><?php echo htmlentities($config['title']); ?><span>(<?php echo htmlentities($vo['remark']); ?>)</span></label> 
												     <input type="hidden" name="<?php echo htmlentities($vo['name']); ?>"  value="<?php echo htmlentities((isset($config['value']) && ($config['value'] !== '')?$config['value']:'')); ?>">
													 <div id="<?php echo htmlentities($vo['name']); ?>" class="container">
														<div id="file_<?php echo htmlentities($vo['name']); ?>">你的浏览器不支持flash,Silverlight或者HTML5！</div>
														<input type="hidden" name="<?php echo htmlentities($vo['name']); ?>"  value="<?php echo htmlentities((isset($config['value']) && ($config['value'] !== '')?$config['value']:'')); ?>">
														<input type="text" name="file_path"  class="ipt" value="<?php echo htmlentities(get_path($config['value'])); ?>">
														<a id="select_<?php echo htmlentities($vo['name']); ?>" href="javascript:void(0);" class='btn_upload'>选择文件</a>
														<a id="post_<?php echo htmlentities($vo['name']); ?>" href="javascript:void(0);" class='btn_upload'>开始上传</a>
													 </div>
							
														
												    <script type="text/javascript">  
													var field="<?php echo htmlentities($vo['name']); ?>";
													upload(field);
												   </script> 	
											  </div>
							                <?php break; ?>
									    <?php endswitch; ?>
									<?php endforeach; endif; else: echo "" ;endif; ?>	
						</div>
						<div class="edit_content_tab none">
							
						</div>
						<div class="btn_group">
						    <input type="hidden" name="id" value="<?php echo htmlentities((isset($info['id']) && ($info['id'] !== '')?$info['id']:"")); ?>">
							<div class="confirm_btn">确认</div>
							<div class="cancel_btn">返回</div>
						</div></form> 
					</div>
				</div>
			</div>
		</div>
	<script>$("video").trigger('play');</script>
  
 <!-- 头部 -->
	
<script src="/public/admin/js/common.js"></script>  

<script>
var html='<footer style=""><p> Powered by <a href="http://www.yershop.com/" target="_blank">yershop V3.0</a> </p></footer>';

$(".content").append(html);
var sid="<?php echo input('module_id')?input('module_id'):$now['id']; ?>";var obj=$("a#"+sid);$(obj).parents("li").eq(0).addClass("active");
</script>
</body>
</html>
<!-- 头部 --> 
