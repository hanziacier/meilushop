<?php /*a:4:{s:67:"/data/wwwroot/yershop/application/index/view/goods/yuyue_lists.html";i:1546763548;s:63:"/data/wwwroot/yershop/application/index/view/public/header.html";i:1546784250;s:62:"/data/wwwroot/yershop/application/index/view/public/color.html";i:1529863444;s:63:"/data/wwwroot/yershop/application/index/view/public/footer.html";i:1546783818;}*/ ?>
<!-- 头部 -->
	<!doctype html><html lang="zh-cn"><head>	<meta charset="utf-8">	<title><?php if(isset($meta_title)): ?><?php echo htmlentities($meta_title); ?>_<?php endif; ?><?php echo C('WEB_SITE_TITLE'); ?></title>	<link href="/public/index/css/base.css" rel="stylesheet" type="text/css"/><link href="/public/index/css/side.css" rel="stylesheet" type="text/css"/>	<link href="/public/index/css/list.css" rel="stylesheet" type="text/css"/>	<link href="/public/index/css/style.css" rel="stylesheet" type="text/css"/>	<script type="text/javascript" src="/public/common/jquery.min.js"></script>	<script type="text/javascript" src="/public/index/js/base.js"></script>	  </head><body>	<!--header start-->		<!--/header end-->	<div class="top"><div class="topbar">                                 <span class="welcome" style="float:left"><a href="javascript:void(0);" onclick="SetHome(this,'<?php echo root_url(); ?>')">设为首页</a>		<a href="javascript:void(0);" onclick="AddFavorite('<?php echo C('SITENAME'); ?>',location.href)" title="<?php echo C('SITENAME'); ?>">收藏本站</a>		</span> 	  		  <div class="topnav">	 	    <span class="operate_nav">	 			<span  id="userfavor"><a href="<?php echo url('mobile/index/index'); ?>"  ><i></i>手机版&nbsp;</a> </span></span>	<span class="operate_nav"> 			<span  id="sell"><a  href="<?php echo url('help/index?id=6'); ?>" >帮助中心&nbsp;<b></b></a> </span>		    </span>  <span class="operate_nav">	 			<span  id="userfavor"><a  href="<?php echo url('collect/index'); ?>" ><i></i>我的收藏&nbsp;</a> </span></span><span class="operate_nav" >	 <span id="cartbtn" ><a href="<?php echo url('cart/index'); ?>" class="shopping_cart" id="shopping_cart" >购物车</a></span></span>  <span class="operate_nav"> 			<span  id="account"><a  href="<?php echo url('order/index'); ?>" >我的订单&nbsp;</a> </span></span>	<span class="operate_nav" >欢迎光临<?php echo C('SITENAME'); if(is_login()): ?><a href="" class="red"><?php echo get_username(); ?></a>,<a href="<?php echo url('User/logout'); ?>">退出</a><?php else: ?> ,请<a href="<?php echo U('User/login'); ?>" >[登录]</a>&nbsp;<a href="<?php echo url('User/register'); ?>" style="padding-left:0;padding-right:10px"> [免费注册] </a> <?php endif; ?>	</span> </div> </div> </div> <script type="text/javascript">function SetHome(obj,url){    try{        obj.style.behavior='url(#default#homepage)';       obj.setHomePage(url);   }catch(e){       if(window.netscape){          try{              netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");         }catch(e){              alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");          }       }else{        alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");       }  }} //收藏本站 bbs.ecmoban.comfunction AddFavorite(title, url) {  try {      window.external.addFavorite(url, title);  }catch (e) {     try {       window.sidebar.addPanel(title, url, "");    }     catch (e) {         alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");     }  }}</script>		<!-- 顶部工具条 结束 -->	<!--/header end-->		<!--logo start-->	<div class="logo w100">		<div class="logo_in in_width">			<h1 class="logo_pic fl"><a href="<?php echo U('index/index'); ?>"><img title="YERSHOP" src="<?php echo C('LOGO'); ?>" width="201" height="59" /></a></h1>						<div class="head-search-layout">				<div class="head-search-bar" id="head-search-bar">					<div class="hd_serach_tab" id="hdSearchTab">						                    </div>                     <form class="search-form" id="top_search_form" action="<?php echo url('search/index'); ?>" method="post">						<input name="act" id="search_act" value="search" type="hidden">                                  <input name="keyword" id="keyword" type="text" class="input-text ui-autocomplete-input" value="" maxlength="60" x-webkit-speech="" lang="zh-CN" onwebkitspeechchange="foo()" placeholder="请输入您要搜索的商品的关键字" data-value="" x-webkit-grammar="builtin:search" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">                        <input type="submit" id="button" value="搜索" class="input-submit">						<p>热门搜索:<?php if(is_array($hotsearch) || $hotsearch instanceof \think\Collection || $hotsearch instanceof \think\Paginator): if( count($hotsearch)==0 ) : echo "" ;else: foreach($hotsearch as $key=>$vo): ?><a href="<?php echo url('Search/index?keyword='.$vo); ?>"><?php echo htmlentities($vo); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></p>                    </form>                   				</div>							</div>									</div>	</div>	<!--/logo end--> <?php if($action != 'cart/index'): ?>	<!--nav start-->	<div class="nav w100 nav_header">		<div class="nav_in in_width">			<div class="sidebar_div fl">				<div class="title">					<i></i>					<h2 class="f14" id="all-class">全部商品分类</h2>				</div>				<ul class="left_sidebar" id="all-goods">									<?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($category) ? array_slice($category,0,9, true) : $category->slice(0,9, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>					<li class="left_sidebar_li">						<div class="product">							<div class="border">																<div class="fl_div fl"><h3><a href="<?php echo U('Goods/lists?id='.$vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></a></h3>								</div>								<span class="fr pic arrow"></span>							</div>													</div>						<div class="product-wrap f14">							<div class="menu_div">																<div class="sub-class" >									<div class="sub-class-content">										<div class="recommend-class">																				</div>										  <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>										<dl>											<dt><h3><a href="<?php echo U('Goods/lists?id='.$vo1['id']); ?>"><?php echo htmlentities($vo1['title']); ?></a></h3></dt>											<dd class="goods-class">												<?php if(is_array($vo1['child']) || $vo1['child'] instanceof \think\Collection || $vo1['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo1['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Goods/lists?id='.$vo2['id']); ?>"><?php echo htmlentities($vo2['title']); ?></a>											 <?php endforeach; endif; else: echo "" ;endif; ?>											</dd>										</dl> <?php endforeach; endif; else: echo "" ;endif; ?>									</div>								</div>															</div>						</div>					</li><?php endforeach; endif; else: echo "" ;endif; ?>				</ul>			</div>						<ul class="nav_list fl">			  <?php if(is_array($channel) || $channel instanceof \think\Collection || $channel instanceof \think\Paginator): $k = 0; $__LIST__ = $channel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>				<li class="<?php if($current_url == $vo['url']): ?>current<?php endif; ?> fl"><a class="f16"href="<?php echo htmlentities(get_url($vo['url'])); ?>"><?php echo htmlentities($vo['title']); ?></a></li>				<?php endforeach; endif; else: echo "" ;endif; ?>			</ul>		</div>	</div>	<!--/nav end-->	<?php endif; ?>	<script>var del_url="<?php echo url('cart/delItem'); ?>";var post_url="<?php echo url('cart/addItem'); ?>";	var dec_url="<?php echo url('cart/decNum'); ?>";var inc_url="<?php echo url('cart/incNum'); ?>";var img_path="/public/index/images";var order_url="<?php echo url('Order/add'); ?>";var del_cart_url='<?php echo url("cart/delCart"); ?>';var clear_cart_url='<?php echo url("cart/clear"); ?>';var collect_url='<?php echo url("collect/add"); ?>';	//分类菜单的显示隐藏                                                                	var oDiv3 = document.getElementById('all-class');	var oDiv4 = document.getElementById('all-goods');	var timer2 = null;//定义定时器变量	//鼠标移入div1或div2都把定时器关闭了，不让他消失	oDiv3.onmouseover = oDiv4.onmouseover = function (){			oDiv4.style.display = 'block';		clearTimeout(timer2);	}	//鼠标移出div1或div2都重新开定时器，让他延时消失	oDiv3.onmouseout = oDiv4.onmouseout = function (){		//开定时器		timer2 = setTimeout(function () { 		oDiv4.style.display = 'none'; },300);	}</script>
<!-- 头部 --> 
<!--crumb start-->
	<div class="crumb w100 crumb_01">
		<div class="top-bar">
					<ul><li>当前位置：</li>
						<li><a href="<?php echo url('index/index'); ?>">首页</a></li>
						<li> &gt; </li>
					<?php echo get_list($info['id']); ?>
					
					</ul>
				</div>
	</div>
	<!--/crumb end-->	
	<!--main start-->
	<!--/nav end-->
	<div class="cate w100">	
		<div class="cate_in in_width">
			<!--分类start--
			<div class="category_title in_width">
				<a href="javascript:void(0);" class="cate_all fl">全部分类</a>
				<?php foreach($info["cate_ids"] as $vo): ?>  
				<span class="fl right_arr"></span>
				<a class="fl"  href="<?php echo U('goods/lists?id='.$vo); ?>"><?php echo htmlentities(get_category_title($vo)); ?></a>
				<?php endforeach; ?>
				<span class="fl right_arr"></span>
				<a class="fl" href="<?php echo U('goods/lists?id='.$info['id']); ?>"><?php echo htmlentities($info['title']); ?></a>
				<span class="fr goods_total">共<span class="goods_total_num"><?php echo htmlentities($res['total']); ?></span>件商品</span>
			</div>
			<!--分类end-->
			
		<?php if(!(empty($brandlist) || (($brandlist instanceof \think\Collection || $brandlist instanceof \think\Paginator ) && $brandlist->isEmpty()))): ?>
			<div class="category_name in_width f12 category_item brand">
				<div class="category_item_title fl">品牌：</div>
				<div class="category_name_list fl category_item_list">
					<ul>
						<?php if(is_array($brandlist) || $brandlist instanceof \think\Collection || $brandlist instanceof \think\Paginator): $k = 0; $__LIST__ = $brandlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>

						<li>
							<a   attr-id="<?php echo htmlentities($vo['id']); ?>" href="javascript:void(0);" onclick=" mutilbrandCheckClick(this);"
							<?php if(is_checked($vo['id'],$info['brand_id'])): ?>class="checked"<?php endif; ?>><?php echo htmlentities($vo['title']); ?></a>
						</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<div class="category_opr fr">
					<span class="category_opr_btn more <?php if(count($brandlist) < 13): ?>none<?php endif; ?>">更多</span>
					<span class="category_opr_btn mul_sel">多选</span>
				</div>
				<div class="multi_check_info in_width none">
					<div class="multi_btn_group">
						<span class="multi_btn_confirm none">确认</span>
						<span class="multi_btn_cancel" onclick="cancelMutilCheck(this);">取消</span>
					</div>
				</div>
			</div>
<?php endif; if(!(empty($attr_list) || (($attr_list instanceof \think\Collection || $attr_list instanceof \think\Paginator ) && $attr_list->isEmpty()))): if(is_array($attr_list) || $attr_list instanceof \think\Collection || $attr_list instanceof \think\Paginator): $k = 0; $__LIST__ = $attr_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
			<!--衣长-->
			<div class="category_length in_width f12 category_item item<?php if($k > 5): ?> none
           <?php endif; ?>">
				<div class="category_item_title fl"><?php echo htmlentities($vo['title']); ?>：</div>
				<div class="category_length_list fl category_item_list">
					<ul>
						<?php if(is_array($vo['type']) || $vo['type'] instanceof \think\Collection || $vo['type'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['type'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
						 <li>
							<a attr-id="<?php echo htmlentities($vo1['id']); ?>" href="javascript:void(0);" onclick="mutilCheckClick(this);" <?php if(is_checked($vo1['id'],input('attrs'))): ?>class="checked"<?php endif; ?>><?php echo htmlentities($vo1['title']); ?></a>
						 </li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<div class="category_opr fr">
				<span class="category_opr_btn more <?php if(count($vo['type']) < 10): ?>none<?php endif; ?>">更多</span>
					<span class="category_opr_btn mul_sel">多选<?php echo htmlentities($vo['id']); ?></span>
				</div>
				<div class="multi_check_info in_width none">
					<div class="multi_btn_group">
						<span class="multi_btn_confirm none">确认</span>
						<span class="multi_btn_cancel" onclick="cancelMutilCheck(this);">取消</span>
					</div>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; if(count($attr_list) > 5): ?>
			<!---->
			<div class="category_more in_width f12" id="categoryMore">
			    <span class="cm_wrap" data-more="<?php if(is_array($attr_list) || $attr_list instanceof \think\Collection || $attr_list instanceof \think\Paginator): $k = 0;$__LIST__ = is_array($attr_list) ? array_slice($attr_list,5,3, true) : $attr_list->slice(5,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><?php echo htmlentities($vo['title']); if(count($attr_list) == ($k+5)): else: ?>、<?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?> 等">
				更多选项（<?php if(is_array($attr_list) || $attr_list instanceof \think\Collection || $attr_list instanceof \think\Paginator): $k = 0;$__LIST__ = is_array($attr_list) ? array_slice($attr_list,5,3, true) : $attr_list->slice(5,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><?php echo htmlentities($vo['title']); if(count($attr_list) == ($k+5)): else: ?>、<?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>等）<i></i></span>
		    </div> 
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>	
	
	<!--goodsmain start-->
	<div class="gm w100">
		<div class="gm_in in_width">
		
			
			<div class="gm_in_right">
					<form id="search_form" action="<?php echo url(''); ?>" method="get">      
				<!--toolbar-->
				<div class="gm_r_toolbar">
					<span class="gm_tools all_rule fl gm_select <?php if($info['order'] == 1): ?>active
<?php endif; ?>">
						<span class="gm_tools_content">综合</span>
						<i class="<?php echo htmlentities((isset($info['range']) && ($info['range'] !== '')?$info['range']:'')); ?>">
						</i>
					</span>
					<span class="gm_tools sales_quantity fl gm_select <?php if($info['order'] == 2): ?>active
<?php endif; ?>">
						<span class="gm_tools_content">销量</span>
						<i class="<?php echo htmlentities((isset($info['range']) && ($info['range'] !== '')?$info['range']:'')); ?> ">
						
						</i>
					</span>
					<span class="gm_tools new_p fl gm_select <?php if($info['order'] == 3): ?>active
<?php endif; ?>">
						<span class="gm_tools_content">新品</span>
						<i class="<?php echo htmlentities((isset($info['range']) && ($info['range'] !== '')?$info['range']:'')); ?>">
						
						</i>
					</span>
					<span class="gm_tools evaluation fl gm_select <?php if($info['order'] == 4): ?>active
<?php endif; ?>">
						<span class="gm_tools_content">评论</span>
					<i class="<?php echo htmlentities((isset($info['range']) && ($info['range'] !== '')?$info['range']:'')); ?>">
						
						</i>
					</span>
					<span class="gm_tools price fl <?php if($info['order'] == 5): ?>active <?php echo htmlentities($info['range']); ?> 
<?php endif; ?> ">
						<span class="gm_tools_content">价格</span>
						<i class="<?php echo htmlentities((isset($info['range']) && ($info['range'] !== '')?$info['range']:'')); ?>">
							
						</i>
					</span>
				
				</div>	
				<input name="range"  value="<?php echo htmlentities((isset($info['range']) && ($info['range'] !== '')?$info['range']:'')); ?>" type="hidden">
				<input name="brand_id"  value="<?php echo htmlentities((isset($info['brand_id']) && ($info['brand_id'] !== '')?$info['brand_id']:'')); ?>" type="hidden">
				<input name="order"  value="<?php echo htmlentities((isset($info['order']) && ($info['order'] !== '')?$info['order']:'')); ?>" type="hidden">
				<input name="id"  value="<?php echo htmlentities((isset($info['id']) && ($info['id'] !== '')?$info['id']:'')); ?>" type="hidden">
				<input name="page"  value="<?php echo input('page'); ?>" type="hidden">
				<input name="sort"   value="<?php echo htmlentities((isset($info['sort']) && ($info['sort'] !== '')?$info['sort']:'')); ?>"type="hidden">
				<input name="baoyou"   value="<?php echo htmlentities((isset($info['baoyou']) && ($info['baoyou'] !== '')?$info['baoyou']:'')); ?>"type="hidden">
				<input name="has"   value="<?php echo htmlentities((isset($info['has']) && ($info['has'] !== '')?$info['has']:'')); ?>"type="hidden">
				<input name="attrs" class="attrs"  type="hidden"  value="<?php echo htmlentities((isset($info['attrs']) && ($info['attrs'] !== '')?$info['attrs']:'')); ?>">
			   </form>
				<!--goods_list-->
				<script type="text/javascript" src="/public/index/js/jquery.lazyload.js"></script>
				<div class="gl_wrapper">
					<?php if(is_array($res['list']) || $res['list'] instanceof \think\Collection || $res['list'] instanceof \think\Paginator): $k = 0; $__LIST__ = $res['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
					<div class="gl_item"><span class="icon_qg"></span>
						<a href="<?php echo url('goods/detail?id='.$vo['id']); ?>"><img class="gl_item_img lazy" data-original="<?php echo htmlentities(get_cover($vo['cover_id'],'path')); ?>"/></a>
						<div class="gl_item_main">
							<ul>
								 <?php $lists= get_pictures($vo['id']); if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): if( count($lists)==0 ) : echo "" ;else: foreach($lists as $k=>$vo1): ?> 
								<li  onmouseover="previews(this)">
									<a>
										<img src="<?php echo htmlentities(get_cover($vo1,'path')); ?>"/>
									</a>
								</li>
								  <?php endforeach; endif; else: echo "" ;endif; ?>
								  
					
								  
							</ul>	
						</div>
						<div class="gl_item_price">￥<?php echo htmlentities($vo['price']); ?></div>
						<a class="gl_item_name" href="<?php echo url('goods/detail?id='.$vo['id']); ?>"> <?php echo htmlentities($vo['title']); ?></a>
						<div class="gl_item_evaluate">已有<?php echo htmlentities($vo['comments']); ?>人评价</div>
							<div class="sg_con01_time gl_item_evaluate"><?php echo htmlentities(time_format($vo['start_time'])); ?>开抢
</div>
						
					

					</div>
					 <?php endforeach; endif; else: echo "" ;endif; ?>
					
					
				</div>
				<div style="clear:both;"></div>
				<div class="pagination_div">
					 <div class="page">
									      <?php echo htmlentities($res['page']); ?>
								 </div>
					
				</div>	
			</div>
			<div style="clear:both;"></div>
		</div>
		
	</div>
	<!--goodsmain end-->
	
 		<script type="text/javascript">
var serverTime =<?php echo time(); ?> * 1000;
$(function(){
    var dateTime = new Date();
    var difference = dateTime.getTime() - serverTime;
	
    setInterval(function(){
      $(".endtime").each(function(){
        var obj = $(this);
        var endTime = new Date(parseInt(obj.attr('value')) * 1000);
        var nowTime = new Date();
        var nMS=endTime.getTime() - nowTime.getTime() + difference;
        var myD=Math.floor(nMS/(1000 * 60 * 60 * 24));
        var myH=Math.floor(nMS/(1000*60*60)) % 24;
        var myM=Math.floor(nMS/(1000*60)) % 60;
        var myS=Math.floor(nMS/1000) % 60;
        var myMS=Math.floor(nMS/100) % 10;
        if(myD>= 0){
			var str = '<span>'+myD+'</span>天<span>'+myH+'</span>时<span>'+myM+'</span>分<span>'+myMS+'</span>秒';
        }else{
			var str = "0天！";	
		}
		obj.html(str);
      });
    }, 100);

});
</script> 
	<script>
	  function deNum(obj){
		   var cur_num = $(obj).parents('.shopping_num').find('input').val();
				if(cur_num <= 0){
					$(obj).parents('.shopping_num').find('input').val(0);
				}else{
					cur_num--;
					$(obj).parents('.shopping_num').find('input').val(cur_num);
				}	
		} 
		
	function addNum(obj){
		  var cur_num = $(obj).parents('.shopping_num').find('input').val();
				if(cur_num >= 99){
					$(obj).parents('.shopping_num').find('input').val(99);
				}else{
					cur_num++;
					$(obj).parents('.shopping_num').find('input').val(cur_num);
				}
		} 
     function addcart(obj,goodsid){
		  
				var num = $(obj).parents('.item_act').find('input').val();
				var cart_url="<?php echo url('cart/addlist'); ?>";
		       $.post(cart_url,{goodsid:goodsid,num:num},function(data){
                     
					 if(data.status){  
					    
					      if(data.isin>0){
					          $('.span_r').text("¥"+data.price);
						      $('.item_num_'+data.sku_id).text(data.num); 
					     }
                         else{					
						    $('#minicart_list ul').append(data.tpl);
					    } 
						
						$('.tNum').text(data.count);
						$('.cart_num').text(data.sum);
						$('.tSum').text("¥"+data.total);
					 }
					 else{
					    alert(data);
					 
					 }
                });
		   
		}   
	function preview(obj){
		   var src=$(obj).attr("src");
		   $(obj).parents(".gl_item").find(".gl_item_img").attr("src",src);
		} 
		$(function(){
			bindEvent();
		});
		function getIds() {     
		   //全选遍历
		    var result=new Array();
			var option = $(".item .checked");
		    option.each(function(i){
			     var id=$(this).attr("attr-id");
				 result.push(id);
		    });
			return result.join(",");		
	  }
	  function getbrands() {     
		   //全选遍历
		    var result=new Array();
			var option = $(".brand .checked");
		    option.each(function(i){
			     var id=$(this).attr("attr-id");
				 result.push(id);
		    });
			return result.join(",");		
	  }
 		function bindEvent(){
		  $(".multi_btn_confirm").click(function(){ 
		   //进行搜索属性拼接，同级属性(OR)用','分割，不同级属性（AND）用'|'分割
		      setBrandVal();
			  setAttrsVal();      
		      $("#search_form").submit();
		  
		});
	
	
			//更多事件绑定
			$(".category_opr_btn.more").click(function(){
				var parent = $(this).parents(".category_item").first();
				var ul_sc = parent.find(".category_item_list").first();
				if($(this).hasClass("active")){
					$(this).removeClass("active");
					$(this).text("更多");
					ul_sc.removeClass("m_h_160");
				}else{
					$(this).addClass("active");
					$(this).text("收起");
					ul_sc.addClass("m_h_160");
				}
				if(parent.hasClass("show_all")){
					parent.removeClass("show_all");
				}else{
					parent.addClass("show_all");
				}
			});
			//多选事件绑定
			$(".category_opr_btn.mul_sel").click(function(){
				var parent= $(this).parents(".category_item");
				var ul_sc = parent.find(".category_item_list").first();
				if(!parent.hasClass("show_all")){
					parent.addClass("show_all");
				}
				ul_sc.addClass("m_h_160");
				parent.find(".category_item_list").addClass("multi_check");
				parent.find(".category_opr").addClass("none");
				parent.find(".multi_check_info").removeClass("none");
			});
			//更多选项展开折叠
			$("#categoryMore .cm_wrap").click(function(){
				if($(this).hasClass("opened")){
					$(this).removeClass("opened");
					$(".cate_in .category_item:gt(5)").addClass("none");
					$(this).html("更多选项（"+ $(this).attr("data-more") +"）<i></i>");
				}else{
					$(this).addClass("opened");
					$(".cate_in .category_item").removeClass("none");
					$(this).html("收起<i></i>");
				}
			});
			//综合、销量、新品、评论事件绑定
			$(".gm_tools.gm_select").click(function(e){
				if(!$(this).hasClass("active")){
					$(this).addClass("active").siblings(".gm_tools.gm_select").removeClass("active");
					$(".gm_tools.price").removeClass("active").removeClass("down").removeClass("up");
				}
				var order=$(this).index()+1;
				$("input[name='order']").val(order); 
				$("#search_form").submit();
			});
	       
			//价格排序
			$(".gm_tools.price").click(function(){
				if(!$(this).hasClass("active")){
					$(this).addClass("active").removeClass("down").addClass("up");
					$(this).siblings(".gm_tools.gm_select").removeClass("active");
					$("input[name='range']").val("up");
				}else{
					if($(this).hasClass("up")){
						$(this).addClass("down").removeClass("up");
						$("input[name='range']").val("down");
					}else{
						$(this).removeClass("down").addClass("up");
						$("input[name='range']").val("up");
					}
				}
				$("input[name='order']").val(5);
				$("#search_form").submit();
			});
			//翻页事件
			$(".page_info .pre").click(function(){
				if($(this).hasClass("disable")){
					return false;
				}else{
					var page=$(".red_font").text();
					$("input[name='page']").val(parseInt(page)-1);
			        $("#search_form").submit();
				}
			});
				//翻页事件
			$(".page_info .next").click(function(){
				if($(this).hasClass("disable")){
					return false;
				}else{
				    var page=$(".red_font").text();
					$("input[name='page']").val(parseInt(page)+1);
			        $("#search_form").submit();
				}
			});
			//仅显示有货和商家包邮多选按钮
			$(".free_post").click(function(){
				if($(this).hasClass("gm_selected")){
					$(this).removeClass("gm_selected");
					$("input[name='baoyou']").val(0);
				}else{
					$(this).addClass("gm_selected");
					$("input[name='baoyou']").val(1);
				}
				$("#search_form").submit();
			});
			//仅显示有货和商家包邮多选按钮
			$(".in_storage").click(function(){
				if($(this).hasClass("gm_selected")){
					$(this).removeClass("gm_selected");
					$("input[name='has']").val(0);
				}else{
					$(this).addClass("gm_selected");
					$("input[name='has']").val(1);
				}
				$("#search_form").submit();
			});
			//清空按钮
			$(".price_arrange .clear").click(function(){
				$(this).parents(".pc_content").find(".pc_content_top input[type='text']").val("");
			});
			//确认按钮
			$(".content_bottom .confirm").click(function(){
				$("#search_form").submit();
			});
			//底部翻页
			$(".pagination_content_div a.page_num").click(function(){
				if(!$(this).hasClass("cur_page")){
					$(this).addClass("cur_page").siblings(".pagination_content_div a.page_num").removeClass("cur_page");
				}
			});
		}
       function   setBrandVal(){
	          var searchString =getbrands();
			  $("input[name='brand_id']").val(searchString);
				 	
	  
	  }
	  function   setAttrsVal(){
	          var searchString = getIds();
			  $("input[name='attrs']").val(searchString);
				 	
	  
	  }
	   //品牌跳转
		function mutilbrandCheckClick(obj){
			var $this = $(obj);
			if($this.hasClass("checked")){
				$this.removeClass("checked");
			}else{
			  $this.addClass("checked");
			}
			 setBrandVal();;
			
			if(!$this.parents(".category_item_list").hasClass("multi_check")){
				$("#search_form").submit();
			}
			
			var siblings = $this.parents(".category_item_list").find("ul li a.checked");
			var parent = $this.parents(".category_item").find(".multi_btn_confirm");
			if(siblings.length > 0){
				parent.removeClass("none");
			}else{
				parent.addClass("none");
			}
			
		}
		//链接跳转
		function mutilCheckClick(obj){
			var $this = $(obj);
			if($this.hasClass("checked")){
				$this.removeClass("checked");
			}else{
				$this.addClass("checked");
			}
			setAttrsVal();
			if(!$this.parents(".category_item_list").hasClass("multi_check")){
				$("#search_form").submit();
			}
			
			var siblings = $this.parents(".category_item_list").find("ul li a.checked");
			var parent = $this.parents(".category_item").find(".multi_btn_confirm");
			if(siblings.length > 0){
				parent.removeClass("none");
			}else{
				parent.addClass("none");
			}
			
		}
		//分页
       $(".page a").click(function(e) {
             e.preventDefault(); // 阻止默认事件
             e.stopPropagation(); // 阻止冒泡
			var Regx = /page\=(\d)/g; 
			var url=$(this).attr("href");
           	var str= url.match(Regx);	
			var str=str.toString();
			var page=str.substring(5);
			$("input[name='page']").val(page);
			$("#search_form").submit();
       });		
		function cancelMutilCheck(obj){
			var parent= $(obj).parents(".category_item").first();
			var ul_sc = parent.find(".category_item_list").first();
			if(parent.hasClass("show_all")){
				parent.removeClass("show_all");
			}
			ul_sc.removeClass("m_h_160");
			parent.find(".category_item_list").removeClass("multi_check");
			parent.find(".category_opr").removeClass("none");
			parent.find(".multi_check_info").addClass("none");
		}
	</script>	
	<!--/main end-->	

		<!--footer  start-->
	<div class="footer w100">
		<div class="footer_in in_width f14">
			<div class="footer_title">
				<ul>
					<li class="qa">
						<span class="left_icon">优</span>
						<div class="right_div">
							<div class="right_div_t_cn">品质保障</div>
							<div class="right_div_t_en">Quality Assurance</div>
						</div>
					</li>
					<li class="wr">
						<span class="left_icon">七</span>
						<div class="right_div">
							<div class="right_div_t_cn">七天无理由退换货</div>
							<div class="right_div_t_en">Without Reason</div>
						</div>
					</li>
					<li class="csr">
						<span class="left_icon">特</span>
						<div class="right_div">
							<div class="right_div_t_cn">特色服务体验</div>
							<div class="right_div_t_en">Characteristic Service Experience</div>
						</div>
					</li>
					<li class="hc">
						<span class="left_icon">帮</span>
						<div class="right_div">
							<div class="right_div_t_cn">帮助中心</div>
							<div class="right_div_t_en">Help Center</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="footer_site_info">
				 <?php if(is_array($footer) || $footer instanceof \think\Collection || $footer instanceof \think\Paginator): $i = 0; $__LIST__ = $footer;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				 <ul class="footer_site_info_ul">
					<li><a href="<?php echo U('help/index?id='.$vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></a></li>
					 <?php if(is_array($vo['ids']) || $vo['ids'] instanceof \think\Collection || $vo['ids'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['ids'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?> 
					<li><a href="<?php echo U('help/index?id='.$vo1['id']); ?>"><?php echo htmlentities($vo1['title']); ?></a></li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
               <?php endforeach; endif; else: echo "" ;endif; ?> 
			   <ul class="footer_site_info_ul">
					<img src="/public/index/images/wx.jpg" WIDTH="100"><P>微信扫一扫关注</P>
				</ul>
				  <ul class="footer_site_info_ul">
					<img src="/public/index/images/alipay.png" WIDTH="100"><P>支付宝扫一扫关注</P>
				</ul>
			</div>
		</div>
	</div>
	<!--/footer  end-->
	<span class="copyright" style="">@2014-2017
	   <a href="http://yershop.com">yershop</a> 版权所有</span>
<script type="text/javascript" src="/public/common/layer/layer.js"></script>

<script type="text/javascript">

	function opensuccess(data){
			  
				   layer.alert(data.msg, {
                            icon: 1,
                             skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                     });
				//$(".alert_success").parents(".mask").removeClass("none"); 
			   setTimeout(function(){
                        if (data.url) {
                          location.href=data.url;
                        }
               },1000);
				
			}
			function openerror(data){
			      layer.alert(data.msg, {
                            icon: 2,
                             skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                     })  ; 
					 setTimeout(function(){
                        if (data.url) {
                          location.href=data.url;
                        }
               },1000);
			}
</script>
<div id="fullbg"></div>

<div class="login_div" style="display:;"><span class="header">您尚未登录</span>
						<i class="arrow" onclick="closeBg()"></i>
						<form id="login_form">
							<div class="list">
								<div class="icon icon_02 fl"><div></div></div>
								<input type="text" name="mobile" class="ipt_01 fl" placeholder="手机号/用户名/邮箱">
							</div>
							<div class="list">
								<div class="icon icon_03 fl"><div></div></div>
								 <input type="text" name="password" placeholder="密码" class="ipt_01 fl">
							</div>
							<div class="last">
								<div class="list fl">
									<div class="icon icon_04 fl"><div></div></div>
									<input type="text" name="verify" placeholder="验证码" class="ipt_02 fl">
								</div>
								<div class="yzm fl"><img  class="verifyimg reloadverify" src="<?php echo captcha_src(); ?>" width="80"></div>
							</div>
							<p class="errmsg"></p> <input type="hidden" name="type" value="1" placeholder="密码" class="ipt_01 fl">
							<input type="submit" id="submain" class="submit f14" value="登录">
							<p  class="reg"><a href="<?php echo url('user/register'); ?>"class="f1">注册</a><a href="<?php echo url('user/forget'); ?>"class="fr">忘记密码?</a></p>
						</form>
					</div>
<script type="text/javascript">

	$("#submain").click(function(){
    		var self =$('#login_form');
			var url="<?php echo url('user/login'); ?>"
    		$.post(url, self.serialize(), success, "json");
    		return false;

    		function success(data){
    			if(data.code){
    				  $(".errmsg").html(data.msg);window.location.reload();
    			} else {
    			     $(".errmsg").html(data.msg);$(".errmsg").css("visibility",'visible');
    				//刷新验证码
    				$(".reloadverify").click();
    			}
    		}
    	});		

//显示灰色 jQuery 遮罩层
function showBg() { 
	$(".login_div").fadeIn();
    var bh = $("body").height();
    var bw = $("body").width();
	
    $("#fullbg").css({
        height:bh,
        width:bw,
        display:"block"
    });
  
}
var is_login="<?php echo is_login(); ?>";
//关闭灰色 jQuery 遮罩
function closeBg() {
    $("#fullbg,.login_div").hide();
}

		    var verifyimg = $(".verifyimg").attr("src");
            $(".reloadverify,.reloadverify_a").click(function(){
			
               if( verifyimg.indexOf('?')>0){
                    $(".verifyimg").attr("src", verifyimg+'&random='+Math.random());
                }else{
                    $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                }
            });


	  </script>
<?php if(!isset($showsidebar)): ?>
<div class="sidebar">
	<div class="quick_link_mian">
		<div class="quick_links_panel">
			<div id="quick_links" class="quick_links">
					<li>
					<a  class="my_qlinks"><i class="setting"></i></a>
					<?php if(is_login()): ?>
					<div id='status' class="ibar_login_box status_login">
						<div class="avatar_box">
							<p class="avatar_imgbox"><img src="<?php echo htmlentities(get_cover($UcenterMember['cover_id'],'path')); ?>" /></p>
							<ul class="user_info">
								<li>用户名：<?php echo get_username(); ?></li>
								<li>级&nbsp;别：普通会员</li>
							</ul>
						</div>
						<div class="login_btnbox">
							<a href="<?php echo url('order/index'); ?>" class="login_order">我的订单</a>
							<a href="<?php echo url('collect/index'); ?>" class="login_favorite">我的收藏</a>
						</div>
						<i class="icon_arrow_white"></i>
					</div>	<script>		
			
	   $(".my_qlinks").click(function(){
	
		$('#status').show();
	});</script>
					<?php else: ?>
					<script>		
			
	   $(".my_qlinks").click(function(){
	
		showBg();
	});</script>
					<?php endif; ?>
				</li>
				<li id="shopCart">
					<a onclick='showbar(1)' class="message_list" ><i class="message"></i><div class="span">购物车</div><span class="cart_num"><?php echo htmlentities((isset($cart["total_num"]) && ($cart["total_num"] !== '')?$cart["total_num"]:"0")); ?></span></a>
				</li>
			
				<li>
					<a onclick='showbar(2)' class="mpbtn_histroy"><i class="zuji"></i></a>
					<div class="mp_tooltip">我的足迹<i class="icon_arrow_right_black"></i></div>
				</li>
				<li>
					<a   onclick='showbar(3)'href="javascript:vod(0)" class="mpbtn_wdsc"><i class="wdsc"></i></a>
					<div class="mp_tooltip">我的收藏<i class="icon_arrow_right_black"></i></div>
				</li>
				<li>
					<a   onclick='showbar(4)' href="javascript:vod(0)" class="mpbtn_recharge"><i class="chongzhi"></i></a>
					<div class="mp_tooltip">我要充值<i class="icon_arrow_right_black"></i></div>
				</li>
			</div>
			<div class="quick_toggle">
				<li>
					<a  href="javascript:vod(0)"><i class="kfzx"></i></a>
					<div class="mp_tooltip">客服中心<i class="icon_arrow_right_black"></i></div>
				</li>
				<li>
					<a id='qr'href="#none"><i class="mpbtn_qrcode"></i></a>
					<div id='qrcodeing' class="mp_qrcode" style="display:none;"><img src="/public/index/images/code_pic.gif" width="148" height="175" /><i class="icon_arrow_white"></i></div>
				</li>
				<li><a href="#top" class="return_top"><i class="top"></i></a></li>
			</div>
		</div>
		<div id="quick_links_pop" class="quick_links_pop hide"></div>
	</div>
</div>

<?php endif; ?>


<div id="cart quick_links_pop" class="quick_links_pop quick_message_list" style='display:none;'><a onclick='hidebar(this)' class="ibar_closebtn" title="关闭"></a><div class="ibar_plugin_title"><h3>购物车</h3></div><div class="pop_panel">
<div class="ibar_plugin_content">

    <div class="ibar_cart_group ibar_cart_product"><div class="ibar_cart_group_header"><span class="ibar_cart_group_title"></span><a href="">我的购物车</a></div><ul id='carthtml'>
   

<?php if(is_array($cartlist) || $cartlist instanceof \think\Collection || $cartlist instanceof \think\Paginator): if( count($cartlist)==0 ) : echo "" ;else: foreach($cartlist as $key=>$vo): ?> 

<li class="cart_item item<?php echo htmlentities($vo['id']); ?>"><div class="cart_item_pic"><a href="<?php echo U('Goods/detail?id='.$vo['goodsid']); ?>"><img width="80" height="80" src="<?php echo htmlentities(get_goods_cover($vo['goodsid'])); ?>"></a></div><div class="cart_item_desc"><a href="<?php echo U('Goods/detail?id='.$vo['goodsid']); ?>" class="cart_item_name"><?php echo htmlentities(get_goods($vo['goodsid'],"title")); ?></a><div class="cart_item_sku"><span>规格：<?php echo htmlentities((isset($vo['specifications']) && ($vo['specifications'] !== '')?$vo['specifications']:"无")); ?></span></div><div class="cart_item_price"><span class="cart_price">￥<?php echo htmlentities($vo['price']); ?>*<em class="num<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities((isset($vo['num']) && ($vo['num'] !== '')?$vo['num']:"无")); ?></em></span></div></div>	

</li>
<?php endforeach; endif; else: echo "" ;endif; ?>
</ul></div><div class="cart_handler"><div class="cart_handler_header"><span class="cart_handler_left">共<span class="cart_price cart_num"><?php echo htmlentities((isset($cart["total_num"]) && ($cart["total_num"] !== '')?$cart["total_num"]:"0")); ?></span>件商品</span><span class="cart_handler_right tSum">￥<?php echo htmlentities((isset($cart['total_money']) && ($cart['total_money'] !== '')?$cart['total_money']:"0")); ?></span></div><a href="<?php echo url('cart/index'); ?>" class="cart_go_btn">去购物车结算</a></div>


</div>

</div><div class="arrow"><i></i></div><div class="fix_bg"></div></div>


<div id="quick_links_pop" class="quick_links_pop quick_message_list" style=""><a href="javascript:;"onclick='hidebar(this)' class="ibar_closebtn" title="关闭"></a><div class="ibar_plugin_title"><h3>我的足迹</h3></div><div class="pop_panel">

<div class="ibar_plugin_content"><div class="ibar-history-head">共<?php echo htmlentities((isset($historynum) && ($historynum !== '')?$historynum:'0')); ?>件产品<a onclick="clearhistory()">清空</a></div><div class="ibar-moudle-product">
  <?php if(isset($history)): if(is_array($history) || $history instanceof \think\Collection || $history instanceof \think\Paginator): $i = 0; $__LIST__ = $history;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> 
<div class="imp_item"><a href="<?php echo U('Goods/detail?id='.$vo['goods_id']); ?>" class="pic"><img src="<?php echo htmlentities($vo['image']); ?>" width="100" height="100" /></a><p class="tit"><a href="<?php echo U('Goods/detail?id='.$vo['goods_id']); ?>"><?php echo htmlentities($vo['title']); ?></a></p><p class="price"><em>￥</em><?php echo htmlentities($vo['price']); ?></p><a onclick="addcartlist(this,<?php echo htmlentities($vo['goods_id']); ?>)" class="btnCart imp-addCart">加入购物车</a></div>
<?php endforeach; endif; else: echo "" ;endif; ?>
<?php endif; ?>

</div>
</div>
	
</div><div class="arrow"><i></i></div><div class="fix_bg"></div></div>
	
<div id="quick_links_pop" class="quick_links_pop quick_message_list" style="left: ;"><a onclick='hidebar(this)' class="ibar_closebtn" title="关闭"></a><div class="ibar_plugin_title"><h3>收藏的产品</h3></div><div class="pop_panel">
<div class="ibar_plugin_content">

    <div class="ibar_cart_group ibar_cart_product"><ul>
	 

	<?php if(isset($c)): if(is_array($c) || $c instanceof \think\Collection || $c instanceof \think\Paginator): if( count($c)==0 ) : echo "null" ;else: foreach($c as $key=>$vo): ?> 

<li class="cart_item item<?php echo htmlentities($vo['id']); ?>"><div class="cart_item_pic"><a href="<?php echo U('Goods/detail?id='.$vo['goods_id']); ?>"><img width="80" height="80" src="<?php echo htmlentities(get_goods_cover($vo['goods_id'])); ?>"></a></div><div class="cart_item_desc"><a href="<?php echo U('Goods/detail?id='.$vo['goods_id']); ?>" class="cart_item_name"><?php echo htmlentities(get_goods($vo['goods_id'],"title")); ?></a><div class="cart_item_sku"><span></span></div><div class="cart_item_price"><span class="cart_price">￥<?php echo htmlentities($vo['price']); ?></span></div></div>	

</li>
	<?php endforeach; endif; else: echo "null" ;endif; ?><?php endif; ?>
	</ul>

</div>
</div>
</div><div class="arrow"><i></i></div><div class="fix_bg"></div></div>


<div id="quick_links_pop" class="quick_links_pop quick_message_list" style="left:;"><a onclick='hidebar(this)'href="javascript:;" class="ibar_closebtn" title="关闭"></a><div class="ibar_plugin_title"><h3>账户充值</h3></div><div class="pop_panel">

'<div class="ibar_plugin_content"><form target="_blank" class="ibar_recharge_form"><div class="ibar_recharge-field"><label>账户</label><div class="ibar_recharge-fl"><div class="ibar_recharge-iwrapper"><input type="text" name="19" placeholder="yershop"></div><i class="ibar_recharge-contact"></i></div></div><div class="ibar_recharge-field"><label>面值</label><div class="ibar_recharge-fl"><p class="ibar_recharge-mod"><span class="ibar_recharge-val">100</span>元</p><i class="ibar_recharge-arrow"></i><div class="ibar_recharge-vbox">
<ul class="charge" style="display:none;"><li><span>10</span>元</li><li class="sanwe selected"><span>100</span>元</li><li><span>20</span>元</li><li class="sanwe"><span>200</span>元</li><li><span>30</span>元</li><li class="sanwe"><span>300</span>元</li><li><span>50</span>元</li><li class="sanwe"><span>500</span>元</li></ul></div></div></div><div class="ibar_recharge-btn"><input type="button" onclick="$('form.pay').submit()" value="立即充值"></div></form></div>
  
</div><div class="arrow"><i></i></div><div class="fix_bg"></div></div>
 <script type="text/javascript" src="/public/index/js/parabola.js"></script>

  <script>		

	   $(".ibar_recharge-mod").click(function(){
	
		$('.charge').show()
	});
	  $(".charge li").click(function(){
		  var num=$(this).find("span").html();
	     $("input[name='money']").val(num);
		$('.ibar_recharge-val').html(num);$('.charge').hide()
	});
	
	var A= document.getElementById('qr');
            var B= document.getElementById('qrcodeing');
            var timerr = null;//定义定时器变量
            //鼠标移入div1或div2都把定时器关闭了，不让他消失
            A.onmouseover = B.onmouseover = function ()
            {
			
               $("#qrcodeing").show();
				//关闭定时执行
                clearTimeout(timerr);
            }
			
            //鼠标移出div1或div2都重新开定时器，让他延时消失
            A.onmouseout = B.onmouseout = function ()
            {
				 //开定时器，每隔200微妙下拉框消失
                timerr = setTimeout(function () { 
                    $("#qrcodeing").hide(); }, 10);
            }

	</script>
<script type="text/javascript">
	 var html='<ul class="sc_goods_ul"><p class="sc_goods_none" >您的购物车还是空的，赶紧行动吧！</p>
</script>
</ul>
<div class="sc_goods_foot" style="display:none;">
<a  href="<?php echo U('cart/index'); ?>" class="my_shopping_cart_btn">查看我的购物车</a>
</div>';
<script>
var is_login='<?php echo is_login(); ?>';
 function showbar(n){
 if(is_login<1&&n>2){
      showBg();return false;
 }
 $('.status_login').hide();
 $('.quick_links_pop').hide();
 $('.quick_links_pop').eq(n).show().animate({right:"40px"});;

 } 
 function hidebar(obj){
      $(obj).parents('.quick_links_pop').toggle();
 
 }
 function addcartlist(obj,goodsid){
		  
				var num =1;
				var cart_url="<?php echo url('cart/addlist'); ?>";
		       $.post(cart_url,{goodsid:goodsid,num:num},function(data){
                     
					 if(data.status){  
					    
					      if(data.isin>0){
					          $('.span_r').text("¥"+data.price);
						      $('.item_num_'+data.sku_id).text(data.num); 
					     }
                         else{					
						    $('#carthtml ul').append(data.tpl);
					    } 
						
						$('.tNum').text(data.count);
						$('.cart_num').text(data.sum);
						$('.tSum').text("¥"+data.total); 
						addpaowuxian();
					 }
					 else{
					     openerror(data);
					 
					 }
                });
		   
		}
	    // 元素以及其他一些变量
var fly = document.querySelector("#flyItem"), 
sidecart = document.querySelector("#shopCart");
	
var ni = 0;
// 抛物线运动
var fline = funParabola(fly, sidecart, {
	speed: 400, //抛物线速度
	curvature: 0.0008, //控制抛物线弧度
	complete: function() {
		fly.style.visibility = "hidden";
		//sidecart.querySelector("span").innerHTML = ++ni;
	}
});		


// 绑定点击事件
if (fly && sidecart) {
	
	[].slice.call(document.getElementsByClassName("jr")).forEach(function(button) {
		button.addEventListener("click", function(event) {
       
				// 滚动大小
			var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft || 0,
			    scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
		
			var left=parseInt(event.clientX + scrollLeft);	
		
			fly.style.right =left + "px";
			fly.style.top = event.clientY + scrollTop + "px";
			fly.style.visibility = "visible";
		
			// 需要重定位
			fline.position().move();		
		});
	});
}
function addpaowuxian(){

dos();	

}

 $(window).scroll(function(event){
      var height= $(document).scrollTop();
	  if(height>100){
		  $('.quick_links_panel .quick_toggle').addClass('quick_links_allow_gotop');
	  }
	  else{
		 $('.quick_links_panel .quick_toggle').removeClass('quick_links_allow_gotop');
	  }
	 
  });


</script>
<script type="text/javascript" src="/public/index/js/common.js"></script>


	<!--弹窗  start-->
	<div class="spxq_tc" style="display:none">
		<p class="scu f14">成功添加到购物车</p>
		<p class="price f12">购物车共有<span class="tNum">1</span>种商品 总金额为：<span class="tSum">¥32400.00</span></p>
		<div class="btns f12">
			<a href="<?php echo U('cart/index'); ?>" class="ck fl">查看购物车</a>
			<a href="javascript:;" class="go fl">继续购物</a>
		</div>
		<a href="javascript:;" class="close f16">X</a>
	</div>
	<!--弹窗  end-->
	<script type="text/javascript">
		$(function(){
			//展开更多信息
			$('.spxq_main .spxq_main_in .top_div .lft_pic .b_div .compare i').click(function(){
				if($(this).hasClass('sel')){
					$(this).removeClass('sel');					
				}else{
					$(this).addClass('sel');		
				}
			});
			//规格
			$('.spxq_main .spxq_main_in .top_div .pro_info .guige .sel_ul li').click(function(){
				$(this).addClass('current').siblings().removeClass('current');
			});
			//材质
			$('.spxq_main .spxq_main_in .top_div .pro_info .caizhi .sel_ul li').click(function(){
				$(this).addClass('current').siblings().removeClass('current');
			});
			//加减
			$('.spxq_main .spxq_main_in .top_div .pro_info .num_input .ipt_l #num_ipt').val(1);
			$('.spxq_main .spxq_main_in .top_div .pro_info .num_input .ipt_l .btn .jian').click(function(){	
				var cur_num = $(this).parent('.btn').siblings('#num_ipt').val();
				if(cur_num <= 0){
					$(this).parent('.btn').siblings('#num_ipt').val(0);
				}else{
					cur_num--;
					$(this).parent('.btn').siblings('#num_ipt').val(cur_num);
				}	
			})
			$('.spxq_main .spxq_main_in .top_div .pro_info .num_input .ipt_l .btn .jia').click(function(){
				var cur_num = $(this).parent('.btn').siblings('#num_ipt').val();
				if(cur_num >= 99){
					$(this).parent('.btn').siblings('#num_ipt').val(99);
				}else{
					cur_num++;
					$(this).parent('.btn').siblings('#num_ipt').val(cur_num);
				}
			})
			//商品分类 
			$('.spxq_main .spxq_main_in .details .lft_pan .spfl .tab_ul li').click(function(e) {
				$(this).addClass('current').siblings().removeClass('current');
				var this_index = $(this).index();
				$(this).closest('.tab_ul').siblings('.tab_div').find('.list_div').eq(this_index).addClass('current');
				$(this).closest('.tab_ul').siblings('.tab_div').find('.list_div').eq(this_index).siblings('.list_div').removeClass('current');
			});
			//商品排行 
			$('.spxq_main .spxq_main_in .details .lft_pan .spph .tab_ul li').click(function(e) {
				$(this).addClass('current').siblings().removeClass('current');
				var this_index = $(this).index();
				$(this).closest('.tab_ul').siblings('.tab_div').find('.list_div').eq(this_index).addClass('current');
				$(this).closest('.tab_ul').siblings('.tab_div').find('.list_div').eq(this_index).siblings('.list_div').removeClass('current');
			});
			
			//右侧tab1
			$('.spxq_main .spxq_main_in .details .rgt_pan .rgt_pan_con').eq(0).show()
			$('.spxq_main .spxq_main_in .details .rgt_pan .tit ul li').click(function(e) {
				$(this).addClass('current').siblings().removeClass('current');
				var index = $(this).index();
				$('.spxq_main .spxq_main_in .details .rgt_pan .rgt_pan_con').eq(index).show().siblings('.spxq_main .spxq_main_in .details .rgt_pan .rgt_pan_con').hide();
			});
			//sel_div
			$('.spxq_main .spxq_main_in .details .rgt_pan .rgt_pan_con.sppj_con .spms .div_r .sel_div').click(function(){
				if($(this).hasClass('cl')){
					$(this).removeClass('cl');					
				}else{
					$(this).addClass('cl');		
				}
			});
			//tit_sel .ul_l li
			$('.spxq_main .spxq_main_in .details .rgt_pan .rgt_pan_con.sppj_con .pj_list .tit_sel .ul_l li input').click(function(){				
				if($(this).attr('checked') == 'checked'){
					$(this).attr('checked','checked');
					$(this).parent('li').siblings('li').children('input').removeAttr("checked");
				}else{
					
					$(this).removeAttr("checked");
					$(this).parent('li').siblings('li').children('input').removeAttr("checked");
				}
			});
			//
			$('.spxq_main .spxq_main_in .details .rgt_pan .rgt_pan_con.sppj_con .pj_list .tit_sel .div_r .xl').click(function(){
				if($(this).hasClass('sel')){
					$(this).removeClass('sel');					
				}else{
					$(this).addClass('sel');		
				}
			});
			//page
			$('.spxq_main .spxq_main_in .details .rgt_pan .rgt_pan_con.sppj_con .pj_list .list_del .page_div .con .page_ul li').click(function(){
				$(this).addClass('current').siblings().removeClass('current');
			});
			
			//page2
			$('.spxq_main .spxq_main_in .details .rgt_pan .rgt_pan_con.xsjl_con .zx_list .xx_list .page_div_03 ul li').click(function(e) {
				$(this).addClass('current').siblings().removeClass('current');			
			});
			
			//商品分类 
			$('.spxq_main .spxq_main_in .details .rgt_pan .rgt_pan_con.gmzx_con .zx_del .zx_tab ul li').click(function(e) {
				$(this).addClass('current').siblings().removeClass('current');
				var this_index = $(this).index();
				$(this).closest('.zx_tab').siblings('.zx_list').eq(this_index).addClass('current');
				$(this).closest('.zx_tab').siblings('.zx_list').eq(this_index).siblings('.zx_list').removeClass('current');
			    var n=this_index;
				consult(1,n);
			});
			
			//弹窗 
			$('.spxq_tc .close').click(function(e) {
				$('.spxq_tc').hide();
			});
			//弹窗 
			$('.spxq_tc .go').click(function(e) {
				$('.spxq_tc').hide();
			});
			
		})
	 function previews(obj){
		           var src= $(obj).find('img').attr("src");
			
					$(obj).parents('.gl_item').find('.gl_item_img').attr("src",src);
			
		    } 
		var goodsid="<?php echo htmlentities($info['id']); ?>";
         function consult(p,type){    //user函数名 一定要和action中的第三个参数一致上面有
                  
                    $.get('<?php echo U("goods/consult"); ?>', {p:p,goodsid:goodsid,type:type}, function(data){  //用get方法发送信息到UserAction中的user方法
                     $("#consult").replaceWith("<div  class='xx_list' id='consult'>"+data+"</div>"); //user一定要和tpl中的一致
                });
         }
		 function sortNum(a,b) {
               return a - b; //升序，如降序，把“a - b”该成“b - a”
         }
        function addCart(){
		     var result = new Array(); 
			 //var ids=$(".caizhi .current");
                $(".caizhi .current").each(function () {
                        result.push($(this).attr("attr_id"));

                });

               if(result){
			       var id=result.sort(sortNum);
				}
				var id=result.join(",");
				var num=$("#num_ipt").val();
				
		       $.post(post_url,{path:id,goodsid:goodsid,num:num},function(data){
                     
					 if(data.status){  
					      $(".none_tips").hide();
					      $(".checkout_box").show();
					      if(data.isin>0){
					          $('.span_r').text("¥"+data.price);
						      $('.item_num_'+data.stock_id).text(data.num); 
					     }
                         else{					
						    $('#minicart_list ul').append(data.tpl);
					    } 
						$('.spxq_tc').show(); 
						$('.tNum').text(data.count);
						$('.cart_num').text(data.sum);
						$('.tSum').text("¥"+data.total);
					 }
					 else{
					 alert(data.info);
					 
					 }
                });
		   
		}     
   </script>
   <script type="text/javascript" charset="utf-8">
  $(function() {
      $("img.lazy").lazyload({effect: "fadeIn"});
  });
</script>
</div>
</body>
</html>
