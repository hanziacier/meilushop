<?php /*a:5:{s:61:"/data/wwwroot/yershop/application/index/view/order/index.html";i:1546761044;s:63:"/data/wwwroot/yershop/application/index/view/public/header.html";i:1546784250;s:62:"/data/wwwroot/yershop/application/index/view/public/color.html";i:1529863444;s:61:"/data/wwwroot/yershop/application/index/view/public/left.html";i:1532338708;s:63:"/data/wwwroot/yershop/application/index/view/public/footer.html";i:1546783818;}*/ ?>
<!-- 头部 -->
	<!doctype html><html lang="zh-cn"><head>	<meta charset="utf-8">	<title><?php if(isset($meta_title)): ?><?php echo htmlentities($meta_title); ?>_<?php endif; ?><?php echo C('WEB_SITE_TITLE'); ?></title>	<link href="/public/index/css/base.css" rel="stylesheet" type="text/css"/><link href="/public/index/css/side.css" rel="stylesheet" type="text/css"/>	<link href="/public/index/css/list.css" rel="stylesheet" type="text/css"/>	<link href="/public/index/css/style.css" rel="stylesheet" type="text/css"/>	<script type="text/javascript" src="/public/common/jquery.min.js"></script>	<script type="text/javascript" src="/public/index/js/base.js"></script>	  </head><body>	<!--header start-->		<!--/header end-->	<div class="top"><div class="topbar">                                 <span class="welcome" style="float:left"><a href="javascript:void(0);" onclick="SetHome(this,'<?php echo root_url(); ?>')">设为首页</a>		<a href="javascript:void(0);" onclick="AddFavorite('<?php echo C('SITENAME'); ?>',location.href)" title="<?php echo C('SITENAME'); ?>">收藏本站</a>		</span> 	  		  <div class="topnav">	 	    <span class="operate_nav">	 			<span  id="userfavor"><a href="<?php echo url('mobile/index/index'); ?>"  ><i></i>手机版&nbsp;</a> </span></span>	<span class="operate_nav"> 			<span  id="sell"><a  href="<?php echo url('help/index?id=6'); ?>" >帮助中心&nbsp;<b></b></a> </span>		    </span>  <span class="operate_nav">	 			<span  id="userfavor"><a  href="<?php echo url('collect/index'); ?>" ><i></i>我的收藏&nbsp;</a> </span></span><span class="operate_nav" >	 <span id="cartbtn" ><a href="<?php echo url('cart/index'); ?>" class="shopping_cart" id="shopping_cart" >购物车</a></span></span>  <span class="operate_nav"> 			<span  id="account"><a  href="<?php echo url('order/index'); ?>" >我的订单&nbsp;</a> </span></span>	<span class="operate_nav" >欢迎光临<?php echo C('SITENAME'); if(is_login()): ?><a href="" class="red"><?php echo get_username(); ?></a>,<a href="<?php echo url('User/logout'); ?>">退出</a><?php else: ?> ,请<a href="<?php echo U('User/login'); ?>" >[登录]</a>&nbsp;<a href="<?php echo url('User/register'); ?>" style="padding-left:0;padding-right:10px"> [免费注册] </a> <?php endif; ?>	</span> </div> </div> </div> <script type="text/javascript">function SetHome(obj,url){    try{        obj.style.behavior='url(#default#homepage)';       obj.setHomePage(url);   }catch(e){       if(window.netscape){          try{              netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");         }catch(e){              alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");          }       }else{        alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");       }  }} //收藏本站 bbs.ecmoban.comfunction AddFavorite(title, url) {  try {      window.external.addFavorite(url, title);  }catch (e) {     try {       window.sidebar.addPanel(title, url, "");    }     catch (e) {         alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");     }  }}</script>		<!-- 顶部工具条 结束 -->	<!--/header end-->		<!--logo start-->	<div class="logo w100">		<div class="logo_in in_width">			<h1 class="logo_pic fl"><a href="<?php echo U('index/index'); ?>"><img title="YERSHOP" src="<?php echo C('LOGO'); ?>" width="201" height="59" /></a></h1>						<div class="head-search-layout">				<div class="head-search-bar" id="head-search-bar">					<div class="hd_serach_tab" id="hdSearchTab">						                    </div>                     <form class="search-form" id="top_search_form" action="<?php echo url('search/index'); ?>" method="post">						<input name="act" id="search_act" value="search" type="hidden">                                  <input name="keyword" id="keyword" type="text" class="input-text ui-autocomplete-input" value="" maxlength="60" x-webkit-speech="" lang="zh-CN" onwebkitspeechchange="foo()" placeholder="请输入您要搜索的商品的关键字" data-value="" x-webkit-grammar="builtin:search" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">                        <input type="submit" id="button" value="搜索" class="input-submit">						<p>热门搜索:<?php if(is_array($hotsearch) || $hotsearch instanceof \think\Collection || $hotsearch instanceof \think\Paginator): if( count($hotsearch)==0 ) : echo "" ;else: foreach($hotsearch as $key=>$vo): ?><a href="<?php echo url('Search/index?keyword='.$vo); ?>"><?php echo htmlentities($vo); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></p>                    </form>                   				</div>							</div>									</div>	</div>	<!--/logo end--> <?php if($action != 'cart/index'): ?>	<!--nav start-->	<div class="nav w100 nav_header">		<div class="nav_in in_width">			<div class="sidebar_div fl">				<div class="title">					<i></i>					<h2 class="f14" id="all-class">全部商品分类</h2>				</div>				<ul class="left_sidebar" id="all-goods">									<?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($category) ? array_slice($category,0,9, true) : $category->slice(0,9, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>					<li class="left_sidebar_li">						<div class="product">							<div class="border">																<div class="fl_div fl"><h3><a href="<?php echo U('Goods/lists?id='.$vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></a></h3>								</div>								<span class="fr pic arrow"></span>							</div>													</div>						<div class="product-wrap f14">							<div class="menu_div">																<div class="sub-class" >									<div class="sub-class-content">										<div class="recommend-class">																				</div>										  <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>										<dl>											<dt><h3><a href="<?php echo U('Goods/lists?id='.$vo1['id']); ?>"><?php echo htmlentities($vo1['title']); ?></a></h3></dt>											<dd class="goods-class">												<?php if(is_array($vo1['child']) || $vo1['child'] instanceof \think\Collection || $vo1['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo1['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Goods/lists?id='.$vo2['id']); ?>"><?php echo htmlentities($vo2['title']); ?></a>											 <?php endforeach; endif; else: echo "" ;endif; ?>											</dd>										</dl> <?php endforeach; endif; else: echo "" ;endif; ?>									</div>								</div>															</div>						</div>					</li><?php endforeach; endif; else: echo "" ;endif; ?>				</ul>			</div>						<ul class="nav_list fl">			  <?php if(is_array($channel) || $channel instanceof \think\Collection || $channel instanceof \think\Paginator): $k = 0; $__LIST__ = $channel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>				<li class="<?php if($current_url == $vo['url']): ?>current<?php endif; ?> fl"><a class="f16"href="<?php echo htmlentities(get_url($vo['url'])); ?>"><?php echo htmlentities($vo['title']); ?></a></li>				<?php endforeach; endif; else: echo "" ;endif; ?>			</ul>		</div>	</div>	<!--/nav end-->	<?php endif; ?>	<script>var del_url="<?php echo url('cart/delItem'); ?>";var post_url="<?php echo url('cart/addItem'); ?>";	var dec_url="<?php echo url('cart/decNum'); ?>";var inc_url="<?php echo url('cart/incNum'); ?>";var img_path="/public/index/images";var order_url="<?php echo url('Order/add'); ?>";var del_cart_url='<?php echo url("cart/delCart"); ?>';var clear_cart_url='<?php echo url("cart/clear"); ?>';var collect_url='<?php echo url("collect/add"); ?>';	//分类菜单的显示隐藏                                                                	var oDiv3 = document.getElementById('all-class');	var oDiv4 = document.getElementById('all-goods');	var timer2 = null;//定义定时器变量	//鼠标移入div1或div2都把定时器关闭了，不让他消失	oDiv3.onmouseover = oDiv4.onmouseover = function (){			oDiv4.style.display = 'block';		clearTimeout(timer2);	}	//鼠标移出div1或div2都重新开定时器，让他延时消失	oDiv3.onmouseout = oDiv4.onmouseout = function (){		//开定时器		timer2 = setTimeout(function () { 		oDiv4.style.display = 'none'; },300);	}</script>
<!-- 头部 --> 
	<!--crumb start-->
	<div class="crumb w100">
		<div class="crumb_in in_width">
			<p><a href="<?php echo url('index'); ?>" class="index_a">首页</a> ><span>我的订单</span></p>
		</div>
	</div>
	<!--/crumb end-->	
	<!--main start-->
	<div class="main w100 grzx_main">
		<div class="main_in in_width grzx_main_in">
			<div class="main_top">
				<div class="left_pan fl">
				
					<div class="fold_nav">
						
						<div class="fold_nav_list">
							<div class="title_div">
								<span class="span_01 fl img_02"></span>
								<span class="span_02 fl f14">订单管理</span>
							</div>
							<ul class="fold_ul">
								<li class="<?php if($action == 'order/index'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('order/index'); ?>">我的订单</a></li>
								<li class="<?php if($action == 'score/index'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('score/index'); ?>">积分订单</a></li>
								<li><a href="<?php echo U('address/index'); ?>">收货地址</a></li>
							</ul>
						</div>
						
						<div class="fold_nav_list">
							<div class="title_div">
								<span class="span_01 fl img_04"></span>
								<span class="span_02 fl f14">我的评价</span>
							</div>
							<ul class="fold_ul">
								<li  class="<?php if($action == 'comment/index'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('comment/index'); ?>">商品评价</a></li>
							</ul>
						</div>
						 <?php if(isset($systems['pin'])): ?>
                       <div class="fold_nav_list">
							<div class="title_div">
								<span class="span_01 fl img_02"></span>
								<span class="span_02 fl f14">我的拼团</span>
							</div>
							<ul class="fold_ul">
								<li class="<?php if($action == 'pin/index'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('pin/index'); ?>">全部团</a></li>
								<li  class="<?php if($action == 'pin/progress'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('pin/progress'); ?>">进行中的团</a></li>
								<li  class="<?php if($action == 'pin/end'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('pin/end'); ?>">已成功的团</a></li>
								<li  class="<?php if($action == 'pin/over'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('pin/over'); ?>">已退款的团</a></li>
							</ul>
						</div>
						<?php endif; ?>
						<div class="fold_nav_list">
							<div class="title_div">
								<span class="span_01 fl img_05"></span>
								<span class="span_02 fl f14">账户管理</span>
							</div>
							<ul class="fold_ul">
								<li  class="<?php if($action == 'member/edit'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('Member/edit'); ?>">账户信息</a></li>
								<li  class="<?php if($action == 'user/profile'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('user/profile'); ?>">密码修改</a></li>
								<li  class="<?php if($action == 'collect/index'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('collect/index'); ?>">我的收藏</a></li>
								
								<li  class="<?php if($action == 'user/logout'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('user/logout'); ?>">安全退出</a></li>
							</ul>
						</div>  <?php if(isset($systems['fenxiao'])): ?>
						<div class="fold_nav_list">
							<div class="title_div">
								<span class="span_01 fl img_02"></span>
								<span class="span_02 fl f14">我的分销</span>
							</div>
							<ul class="fold_ul">
								<li class="<?php if($action == 'fenxiao/index'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('fenxiao/index'); ?>">我的团队</a></li>
							     <li  class="<?php if($action == 'fenxiao/order'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('fenxiao/order'); ?>">团队订单</a></li>
								 <li  class="<?php if($action == 'fenxiao/member'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('fenxiao/member'); ?>">成员管理</a></li>
								<li  class="<?php if($action == 'fenxiao/mine'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('fenxiao/mine'); ?>">我的佣金</a></li>
								<li  class="<?php if($action == 'fenxiao/plan'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('fenxiao/plan'); ?>">我的推广</a></li>
							</ul>
						</div><?php endif; ?>
						<div class="fold_nav_list">
							<div class="title_div">
								<span class="span_01 fl img_06"></span>
								<span class="span_02 fl f14">交易管理</span>
							</div>
							<ul class="fold_ul">
							    <li  class="<?php if($action == 'pay/index'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('pay/index'); ?>">余额充值</a></li>
								<li  class="<?php if($action == 'pay/lists'): ?>li_cur<?php endif; ?>"><a href="<?php echo U('pay/lists'); ?>">充值记录</a></li>
							</ul>
						</div>
					</div>
				</div>

		<div class="grzx_right_pan fr">
				<h3 class="cr_h3">我的订单</h3>
			
				<div class="wddd_right_pan fr" style="margin-top:10px;">
				
					<div class="top_tab">
						<ul class="fl f14">
							<li  <?php if(empty($info['status']) || (($info['status'] instanceof \think\Collection || $info['status'] instanceof \think\Paginator ) && $info['status']->isEmpty())): ?>class="current"<?php endif; ?>>
								<a href="<?php echo U('order/index?status=0'); ?>">所有订单<span></span></a>
							</li>

							<li <?php if(!(empty($info['status']) || (($info['status'] instanceof \think\Collection || $info['status'] instanceof \think\Paginator ) && $info['status']->isEmpty()))): if($info['status'] == 1): ?>class="current"<?php endif; ?><?php endif; ?>>
								<a href="<?php echo U('order/index?status=1'); ?>">待发货<span></span></a>
							</li>
						
							<li <?php if(!(empty($info['status']) || (($info['status'] instanceof \think\Collection || $info['status'] instanceof \think\Paginator ) && $info['status']->isEmpty()))): if($info['status'] == 2): ?>class="current"<?php endif; ?><?php endif; ?>>
								<a href="<?php echo U('order/index?status=2'); ?>">待收货<span></span></a>
							</li>
							<li <?php if(!(empty($info['status']) || (($info['status'] instanceof \think\Collection || $info['status'] instanceof \think\Paginator ) && $info['status']->isEmpty()))): if($info['status'] == 3): ?>class="current"<?php endif; ?><?php endif; ?>>
								<a href="<?php echo U('order/index?status=3'); ?>">已确认<span></span></a>
							</li>
					
						</ul>
						<div class="hsz fr f12">
							
						</div>
					</div>
					<div class="tab_con">
                        <form action="<?php echo U(''); ?>" method="post" class="order_sn">
						    <input type="hidden" name="order_sn" class="order_sn"/>
						</form>
						<form action="<?php echo U(''); ?>" method="post">
							<!--div class="sear">
								<div class="sear_ipt fl">
									<input type="text"name="order_sn" placeholder="输入订单号进行搜索" id="order_sn" class="ipt_01 fl"/>
									<input type="button" class="ipt_02 fl" onclick="submitfrm();" value="订单搜索"/>
								</div>
								<div class="more fl">
									<span class="txt">更多筛选条件</span>
									<span class="icon"><img src="/public/index/images/wddd_icon_01.gif"></span>
								</div>
							</div-->
							<div class="sc_xl f12">
									<div class="div_03 fl">
									<label for="">订单号</label>
									<input type="text" name="order_sn"/>
								</div>
								<div class="div_02 fl">
									<label for="">成交时间</label>
									<input type="input" name="start_time" class="laydate-icon time_start" value="<?php echo htmlentities((isset($info['start_time']) && ($info['start_time'] !== '')?$info['start_time']:'')); ?>" id="start_time"/>
									<span>-</span>
									<input type="input"  name="end_time" value="<?php echo htmlentities((isset($info['end_time']) && ($info['end_time'] !== '')?$info['end_time']:'')); ?>"class="laydate-icon time_end"  id="end_time"/>
								</div>
							    <div class="div_03 fl">
									<label for="">收件人</label>
									<input type="text" name="username"/>
								</div>
								<div class="div_03 fl">
									<label for="">手机</label>
									<input type="text" name="mobile"/>
								</div>
								<div class="div_03 fl">
									<label for="">收件地址</label>
									<input type="text" name="address"/>
								</div>
								
								
								
								<button class="sc_btn fl"type="submit">搜索</button>
							</div>
						</form>
				
						<table class="bought_table f12">
							<tbody>
								<tr>
									<th class="th_01">宝贝</th>
									<th class="th_02">单价</th>
									<th class="th_03">数量</th>
									<th class="th_04">商品操作</th>
									<th class="th_05">实付款</th>
									<th class="th_06">
										<div class="field_select">
											<div class="zt"><span class="txt">交易状态</span><span class="icon"><img src="/public/index/images/wddd_icon_03.gif"></span></div>
											<ul class="down_list">
												<li class="current"><a href="javascript:;">交易状态</a></li>
												<li><a href="javascript:;">交易状态</a></li>
												<li><a href="javascript:;">交易状态</a></li>
											</ul>
										</div>
									</th>
									<th class="th_07">交易操作</th>
								</tr>
							</tbody>
						</table>
						<?php if(!(empty($res['list']) || (($res['list'] instanceof \think\Collection || $res['list'] instanceof \think\Paginator ) && $res['list']->isEmpty()))): ?>
						<div class="sle_all f12">
							<label for="">
								<input type="checkbox" class="check-all"/>
								<span class="date">全选</span>
								<a  onclick='confirmAll(<?php echo htmlentities($vo['id']); ?>);' class="pl">批量确认收货</a>
							</label>
							
						</div>						
			           <?php if(is_array($res['list']) || $res['list'] instanceof \think\Collection || $res['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $res['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<div class="bought_list f12">
							<table class="top_table">
								<tbody>
									<tr>
										<td class="td_01">
											<input type="checkbox" class="ids" value="<?php echo htmlentities($vo['id']); ?>" />
											<span class="date"><?php echo htmlentities(date('Y-m-d H:i',!is_numeric($vo['create_time'])? strtotime($vo['create_time']) : $vo['create_time'])); ?></span>
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
													<a href="<?php echo U('Goods/detail?id='.$vo1['goods_id']); ?>" class="pic fl"><img src="<?php echo htmlentities(get_goods_cover($vo1['goods_id'])); ?>" width="80" height="80"></a>
													<div class="info fl">
														<a href="<?php echo U('Goods/detail?id='.$vo1['goods_id']); ?>" class="name"><?php echo htmlentities($vo1['title']); ?></a>
														<p class="color">规格：<?php echo htmlentities($vo1['specifications']); ?></p>
														
													</div>
												</div>
												<div class="div_02 fl">
													<p class="old">￥<?php echo htmlentities($vo1['price']); ?></p>
													<p class="new">￥<?php echo htmlentities($vo1['price']); ?></p>
												</div>
												<div class="div_03 fl">
													<span><?php echo htmlentities($vo1['num']); ?></span>
												</div>
												<div class="div_04 fl">
												 <?php if($vo1['status'] == 0): ?>
												  无
												   <?php endif; if($vo1['status'] == 1): ?>
												  无
												   <?php endif; if($vo1['status'] == 2): ?>
												  无
												   <?php endif; if($vo1['status'] == 3): ?>
												  <a href="<?php echo U('service/applyreturn?id='.$vo1['id']); ?>" class="sh">退货</a>
												   <?php endif; if($vo1['status'] == 4): ?>
												  <a href="<?php echo U('service/applyreturn?id='.$vo1['id']); ?>" class="sh">处理中</a>
												  <?php endif; if($vo1['status'] == 5): ?>
												  <a href="<?php echo U('service/applyreturn?id='.$vo1['id']); ?>" class="sh">已完成</a>
												   <?php endif; if($vo1['comment_status'] == 7): ?>
												<a href="<?php echo U('comment/write?id='.$vo1['id']); ?>" class="ts">评价</a>
												<?php endif; if($vo1['comment_status'] == 2): ?>已评价<?php endif; ?>
										
												</div>
											</div>
											<?php endforeach; endif; else: echo "" ;endif; ?>										
										</td>										
										<td class="td_02">
											<p class="total">￥<?php echo htmlentities($vo['total_money']); ?></p>
											<p class="yf">(含运费：￥<?php echo htmlentities($vo['ship_price']); ?>)</p>
											<?php if($vo['type'] == 1): ?><div class="phone">手机订单</div><?php endif; ?>
										</td>
										<td class="td_03">
										<a href="javascript:;" class="jycg">
										<?php if($vo['status'] == 0): ?>待支付<?php endif; if($vo['status'] == 1): ?>待发货<?php endif; if($vo['status'] == 2): ?>已发货<?php endif; if($vo['status'] == 3): ?>已确认<?php endif; if($vo['status'] == 4): ?>申请取消中<?php endif; if($vo['status'] == 5): ?>取消订单被拒绝<?php endif; if($vo['status'] == 6): ?>订单已取消<?php endif; ?>
										</a></br>
											<a href="<?php echo U('order/detail?id='.$vo['id']); ?>" class="ddxq">订单详情</a>
											
											
										</td>
										<td class="td_04">
										<?php if($vo['status'] == 0): ?><a class="btn-active" href="<?php echo U('order/pay?id='.$vo['id']); ?>" >前去支付</a><?php endif; if($vo['status'] == 2): ?><a class="btn-active"onclick='confirmOrder(<?php echo htmlentities($vo['id']); ?>);' >确认收货</a>
        <?php endif; ?>
										
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<?php endforeach; endif; else: echo "" ;endif; else: ?>
						    <span style="text-align:center;width:100%;display:block;">无数据！</span>
						<?php endif; ?>
						<div class="page_div page">
							<?php echo $res['page']; ?>
							
						</div>	
					</div>
					
						
					</div>
				</div>	
			</div>		
				
				
			</div>			
		</div>
	</div>
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

	   <div class="mask none">
			<div class="alert_success alert_div">
				<div class="alert_header">提示</div>
				<div class="alert_content"><i></i><span class="sucess_msg">操作成功</span></div>
				<div class="alert_btn">确定</div>
				<span class="alert_close"></span>
			</div>
		</div>
		<div class="mask none">
			<div class="alert_error alert_div">
				<div class="alert_header">提示</div>
				<div class="alert_content"><i></i><span class="error_msg">操作失败</span></div>
				<div class="alert_btn">确定</div>
				<span class="alert_close"></span>
			</div>
		</div>
 <script type="text/javascript" src="/public/index/js/laydate/laydate.js"></script>	
 <script type="text/javascript">
	$("select[name='status']").val("<?php echo htmlentities((isset($info['status']) && ($info['status'] !== '')?$info['status']:'1')); ?>");
	$("select[name='type']").val("<?php echo htmlentities((isset($info['type']) && ($info['type'] !== '')?$info['type']:'0')); ?>");
	$("select[name='pay_type']").val("<?php echo htmlentities((isset($info['pay_type']) && ($info['pay_type'] !== '')?$info['pay_type']:'1')); ?>");	
	$("select[name='is_invoice']").val("<?php echo htmlentities((isset($info['is_invoice']) && ($info['is_invoice'] !== '')?$info['is_invoice']:'0')); ?>");
	laydate({
		elem: '#start_time', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
	    format: 'YYYY-MM-DD hh:mm:ss', 
	    min: laydate.now(), //设定最小日期为当前日期//目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
	    event: 'focus' //响应事件。如果没有传入event，则按照默认的click
	});
   laydate({  
  
    elem: '#end_time', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
     format: 'YYYY-MM-DD hh:mm:ss', 
     min: laydate.now(), //设定最小日期为当前日期//目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
     event: 'focus' //响应事件。如果没有传入event，则按照默认的click
   });

	$(".mask .alert_div .alert_close").click(function(){
		$(this).parents(".mask").addClass("none");
	});
	$(".mask .alert_div .alert_btn").click(function(){
		$(this).parents(".mask").addClass("none");
	});
	$(".tjpj").click(function(){
		  opensuccess();
	})
	
	
	function confirmOrder(id){
			var url="<?php echo url('order/confirm'); ?>";
		      $.post(url,{id:id},function(data){
  
					 if(data.code){  
					     opensuccess(data);
					 }
					 else{
					      openerror(data);
					 }
              });
		  
		}
	 function delOrder(id){
			 var url="<?php echo url('order/del'); ?>";
		      $.post(url,{id:id},function(data){
					 if(data.code){  
					     opensuccess(data);
					 }
					 else{
					      openerror(data);
					 }
              });
		  
	 }	
	 function submitfrm(){
	    var order_sn=$("input#order_sn").val();
        $("input.order_sn").val(order_sn);
		$("form.order_sn").submit();
		  
	}
	function confirmAll(id){
	  var ids=getIds();
			var url="<?php echo url('order/confirm'); ?>";
		      $.post(url,{id:ids},function(data){
					 if(data.code){  
					     opensuccess(data);
					 }
					 else{
					      openerror(data);
					 }
              });
		  
		}
	  function getIds(){ //取值
		    var option = $("input.ids");
		    var result=new Array();
		    option.each(function(i){
		 	     result.push($(this).val());
		   });
           return result.join(',');
        
	  }			

	$(function(){
		//tab_ul
		
		$('.grzx_main_in .wddd_right_pan .tab_con').eq(0).show();
		$('.grzx_main_in .wddd_right_pan .top_tab ul li').click(function(){
			$(this).addClass('current').siblings().removeClass('current');
			var this_index =$(this).index();				
			$('.grzx_main_in .wddd_right_pan .tab_con').eq(this_index).show().siblings('.tab_con').hide();
		});
				
		//展开更多信息
		$('.grzx_main_in .wddd_right_pan .tab_con .sear .more').click(function(){
			if($(this).children('.icon').children('img').attr('src').match('wddd_icon_01')){
				$(this).children('.icon').children('img').attr('src','/public/index/images/wddd_icon_02.gif');
				$('.grzx_main_in .wddd_right_pan .tab_con .sc_xl').show();
			}else{
				$(this).children('.icon').children('img').attr('src','/public/index/images/wddd_icon_01.gif');
				$('.grzx_main_in .wddd_right_pan .tab_con .sc_xl').hide();					
			}
		});
					
		//交易状态
		$('.grzx_main_in .wddd_right_pan .tab_con .bought_table .th_06 .field_select .zt').click(function(){
			if($(this).children('.icon').children('img').attr('src').match('wddd_icon_03')){
				$(this).children('.icon').children('img').attr('src','/public/index/images/wddd_icon_04.gif');
				$('.grzx_main_in .wddd_right_pan .tab_con .bought_table .th_06 .field_select .down_list').show();
			}else{
				$(this).children('.icon').children('img').attr('src','/public/index/images/wddd_icon_03.gif');
				$('.grzx_main_in .wddd_right_pan .tab_con .bought_table .th_06 .field_select .down_list').hide();					
			}
		});
		$('.grzx_main_in .wddd_right_pan .tab_con .bought_table .th_06 .field_select .down_list li').click(function(){
			$(this).addClass('current').siblings().removeClass('current');
		});
		//sle_all
		$('.grzx_main_in .wddd_right_pan .tab_con .sle_all .btns button').click(function(){
			$(this).addClass('current').siblings().removeClass('current');
		});	
		//sle_all_01
		$('.grzx_main_in .wddd_right_pan .tab_con .sle_all_01 .btns button').click(function(){
			$(this).addClass('current').siblings().removeClass('current');
		});	
		//page
		$('.grzx_main_in .wddd_right_pan .tab_con .page_div .con .page_ul li').click(function(){
			$(this).addClass('current').siblings().removeClass('current');
		});
		
	//全选的实现
	$(".check-all").click(function(){
		$(".ids").prop("checked", this.checked);
		
	});
	$(".ids").click(function(){
		var option = $(".ids");
		option.each(function(i){
			if(!this.checked){
				$(".check-all").prop("checked", false);
				return false;
			}else{
				$(".check-all").prop("checked", true);
			}
		});
       
	});
		
	})
	</script>
</body>
</html>
