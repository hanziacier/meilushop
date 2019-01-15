<?php /*a:4:{s:60:"/data/wwwroot/yershop/application/admin/view/cate/index.html";i:1520503616;s:63:"/data/wwwroot/yershop/application/admin/view/public/header.html";i:1531675504;s:63:"/data/wwwroot/yershop/application/admin/view/public/dialog.html";i:1520503620;s:63:"/data/wwwroot/yershop/application/admin/view/public/footer.html";i:1531675686;}*/ ?>
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
				<div class="edit_title"><?php echo htmlentities((isset($meta_title) && ($meta_title !== '')?$meta_title:"")); ?></div>
				<div class="articlelist">
					<div class="edit">
						<div class="edit_left ">
								<a href="<?php echo U('add'); ?>" class="add cur">新增</a>
								<a  data-url="<?php echo U('del'); ?>" class="delete cur">删除</a>
						</div>
						<div class="search_right">
							
						</div>
					</div>
					<div class="article_table">
						<div class="article_table_header article_table_tr">
							<!--加class往后面加，不要加在已有class前面-->
							<div class="article_folder article_table_th" w_percent="18">折叠</div>
								<div class="article_id article_table_th" w_percent="18">id</div>
							<div class="article_name article_table_th" w_percent="50">名称</div>
							<div class="article_sort article_table_th" w_percent="10">排序</div>
							<div class="article_deploy article_table_th" w_percent="10">状态</div>
							<div class="list_opr article_table_th" w_percent="22">操作</div>
						</div>
						 <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<div class="first_level_group opened">
							<div class="first_level article_table_tr">
								<div class="article_folder">
										<span class="folder_icon"></span>
								</div>
								<div class="article_id">
									<?php echo htmlentities($vo['id']); ?>
								</div>
								<div class="article_name">
								<span><?php echo htmlentities($vo['title']); ?></span>
									 <a href="<?php echo url('add?pid='.$vo['id']); ?>" class="add_article"></a>
								</div>
								<div class="article_sort">
									<?php echo htmlentities($vo['sort']); ?>
								</div>
								<div class="article_deploy"><?php echo htmlentities($vo['status']); ?></div>
								<div class="list_opr">
									<span class="opr_box">
										 <a href="<?php echo url('edit?id='.$vo['id']); ?>" class="edit_btn cur">编辑</a>
									 <a data-url="<?php echo url('del?id='.$vo['id']); ?>" class="del_btn cur">删除</a>
									</span>
								</div>
							</div> 
							 <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
							<div class="second_level_group opened">
								<div class="second_level article_table_tr">
									<div class="article_folder">
										<span class="folder_icon"></span>
									</div>
									<div class="article_id">
									<?php echo htmlentities($vo1['id']); ?>
								   </div>
									<div class="article_name">
									<span><?php echo htmlentities($vo1['title']); ?></span>
									 	 <a href="<?php echo url('add?pid='.$vo1['id']); ?>" class="add_article"></a>
								   </div>
								   <div class="article_sort">
									<?php echo htmlentities($vo1['sort']); ?>
								   </div>
								   <div class="article_deploy"><?php echo htmlentities($vo1['status']); ?></div>
									<div class="list_opr">
										<span class="opr_box">
										 <a href="<?php echo url('edit?id='.$vo1['id']); ?>" class="edit_btn cur">编辑</a>
									      <a data-url="<?php echo url('del?id='.$vo1['id']); ?>" class="del_btn cur">删除</a>
										</span>
									</div>
								</div>
								<?php if(!(empty($vo1['child']) || (($vo1['child'] instanceof \think\Collection || $vo1['child'] instanceof \think\Paginator ) && $vo1['child']->isEmpty()))): if(is_array($vo1['child']) || $vo1['child'] instanceof \think\Collection || $vo1['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo1['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
								<div class="third_level article_table_tr">
									<div class="article_folder">
									    <span class="folder_icon"></span>
									</div>
									<div class="article_id">
									 <?php echo htmlentities($vo2['id']); ?>
								   </div>
									<div class="article_name">
									  <span><?php echo htmlentities($vo2['title']); ?></span>
									   	 <a href="<?php echo url('add?pid='.$vo2['id']); ?>" class="add_article"></a>
								    </div>
								    <div class="article_sort">
									    <?php echo htmlentities($vo2['sort']); ?>
								    </div>
								    <div class="article_deploy"><?php echo htmlentities($vo2['status']); ?></div>
									<div class="list_opr">
										<span class="opr_box">
										 <a href="<?php echo url('edit?id='.$vo2['id']); ?>" class="edit_btn cur">编辑</a>
									 <a data-url="<?php echo url('del?id='.$vo2['id']); ?>" class="del_btn cur">删除</a>
										</span>
									</div>
								</div>
								
							<?php endforeach; endif; else: echo "" ;endif; ?>	<?php endif; ?>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
							</div>
							<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>	</div>	</div>	</div>	</div>
		</div>
		<script>
			$(function(){
				initPage();
				window.onresize=function(){
					initPage();
				}
				bindEvent();
			});
			
			function initPage(){
				
				$(".nav_tree").css("min-height",($(window).height() - 86) + 'px');
				$(".content").css("min-height",($(window).height() - 86) + 'px');
				$(".nav_tree").attr("min-height",$(window).height() - 86);
				$(".content").attr("min-height",$(window).height() - 86);
				$(".articlelist").attr("min-height",$(window).height() - 86);
				$(".articlelist").css("min-height",($(window).height() - 86) + 'px');
				
				var currentRightHeight = $(".content").height();
				var currentNavHeight = $(".nav_tree").height();
				if(currentRightHeight < currentNavHeight){
					$(".articlelist").css("min-height",currentNavHeight + 'px');
					$(".articlelist").attr("min-height",currentNavHeight);
				}else{
					$(".nav_tree").css("min-height",currentRightHeight + 'px');
				}
				
				
			}
			
			function bindEvent(){
				$(".p_menue").on('click',function(){
					if($(this).parent(".menue").hasClass("down")){
						$(this).parent(".menue").removeClass("down").addClass("up");
					}else{
						$(this).parent(".menue").removeClass("up").addClass("down");
					}
					calculateHeight();
				});
				$(".c_menue_item").on("click",function(){
					if(!$(this).hasClass("checked")){
						$(".nav_tree_list .c_menue_item").removeClass("checked");
						$(this).addClass("checked");
					}
				})
				$(".close_tips").click(function(){
					$(".tips_msg").hide();
					calculateHeight();
				});
				
				
				/****树形菜单展开**/
				$(".first_level .folder_icon").click(function(){
					var parent= $(this).parents(".first_level_group").first();
					if(parent.hasClass("closed")){
						parent.removeClass("closed").addClass("opened");
					}else if(parent.hasClass("opened")){
						parent.removeClass("opened").addClass("closed");
						parent.find(".second_level_group").removeClass("opened").addClass("closed");
					}
					calculateHeight();
				});
				$(".second_level .folder_icon").click(function(){
					var parent= $(this).parents(".second_level_group").first();
					if(parent.hasClass("closed")){
						parent.removeClass("closed").addClass("opened");
					}else if(parent.hasClass("opened")){
						parent.removeClass("opened").addClass("closed");
					}
					calculateHeight();
				});
			}
			
			function calculateHeight(){
				var realHeight = $(".articlelist .edit").outerHeight() + $(".article_table").outerHeight();
				var realLeftHeight = $(".user_info_detail").outerHeight() + $(".nav_tree_list").outerHeight();
				var currentNavHeight = $(".nav_tree").height();
				if(realHeight > $(".articlelist").attr("min-height")){
					if(realHeight > currentNavHeight){
						$(".nav_tree").css("min-height",realHeight + 'px');
					    $(".articlelist").css("min-height",realHeight + 'px');
					}else{
						if(realLeftHeight > realHeight){
							$(".articlelist").css("min-height",realLeftHeight + 'px');
							$(".nav_tree").css("min-height",realLeftHeight + 'px');
						}else{
							$(".nav_tree").css("min-height",realHeight + 'px');
						    $(".articlelist").css("min-height",realHeight + 'px');
						}
					}
				}else{
					if(currentNavHeight >= $(".articlelist").attr("min-height")){
						if(realLeftHeight >= $(".articlelist").attr("min-height")){
							$(".articlelist").css("min-height",realLeftHeight + 'px');
							$(".nav_tree").css("min-height",realLeftHeight + 'px');
						}else{
							$(".nav_tree").css("min-height",$(".articlelist").attr("min-height") + 'px');
							$(".articlelist").css("min-height",$(".articlelist").attr("min-height")  + 'px');
						}
						
					}else{
						$(".nav_tree").css("min-height",$(".articlelist").attr("min-height") + 'px');
						$(".articlelist").css("min-height",$(".articlelist").attr("min-height")  + 'px');
					}
				}
			}
			
			
	
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
