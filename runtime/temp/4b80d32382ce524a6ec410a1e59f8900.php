<?php /*a:2:{s:61:"/data/wwwroot/yershop/application/index/view/index/index.html";i:1546182892;s:63:"/data/wwwroot/yershop/application/index/view/public/footer.html";i:1546783818;}*/ ?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo htmlentities($meta_title); ?>_<?php echo C('WEB_SITE_TITLE'); ?></title>
	<link href="/public/index/css/base.css" rel="stylesheet" type="text/css"/>
	<link href="/public/index/css/style.css" rel="stylesheet" type="text/css"/>	
	<link href="/public/index/css/side.css" rel="stylesheet" type="text/css"/>	

	<script type="text/javascript" src="/public/index/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/public/index/js/base.js"></script>
	<script type="text/javascript" src="/public/index/js/jquery.jqzoom.js"></script>
	<script type="text/javascript" src="/public/index/js/lvjing.js"></script>
	<script type="text/javascript" src="/public/index/js/jquery.lazyload.js"></script>
</head>

<body>
	<!--header start-->
	
	<!--/header end-->
	<div class="top">
<div class="topbar">


                   

              <span class="welcome" style="float:left"><a href="javascript:void(0);" onclick="SetHome(this,'<?php echo root_url(); ?>')">设为首页</a>
		<a href="javascript:void(0);" onclick="AddFavorite('<?php echo C('SITENAME'); ?>',location.href)" title="<?php echo C('SITENAME'); ?>">收藏本站</a>
		</span> 	  
		
  
<div class="topnav">
	 	  
  <span class="operate_nav">
	 	
		<span  id="userfavor"><a href="<?php echo url('mobile/index/index'); ?>"  ><i></i>手机版&nbsp;</a> </span>

</span>	
<span class="operate_nav"> 	
		<span  id="sell"><a  href="<?php echo url('help/index?id=6'); ?>" >帮助中心&nbsp;<b></b></a> </span>
		  
  
</span>

  <span class="operate_nav">
	 	
		<span  id="userfavor"><a  href="<?php echo url('collect/index'); ?>" ><i></i>我的收藏&nbsp;</a> </span>

</span>
<span class="operate_nav" >	 

<span id="cartbtn" ><a href="<?php echo url('cart/index'); ?>" class="shopping_cart" id="shopping_cart" >购物车</a></span>
</span>
 
 <span class="operate_nav"> 	
		<span  id="account"><a  href="<?php echo url('order/index'); ?>" >我的订单&nbsp;</a> </span>

</span>

	
<span class="operate_nav" >欢迎光临<?php echo C('SITENAME'); if(is_login()): ?><a href="" class="red"><?php echo get_username(); ?></a>,<a href="<?php echo url('User/logout'); ?>">退出</a><?php else: ?>
 ,请<a href="<?php echo U('User/login'); ?>" >[登录]</a>&nbsp;<a href="<?php echo url('User/register'); ?>" style="padding-left:0;padding-right:10px"> [免费注册] </a> 
<?php endif; ?>
	</span> 
</div> </div>
 </div>
 <script type="text/javascript">


function SetHome(obj,url){

    try{

        obj.style.behavior='url(#default#homepage)';

       obj.setHomePage(url);

   }catch(e){

       if(window.netscape){

          try{

              netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");

         }catch(e){

              alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");

          }

       }else{

        alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");

       }

  }

}

 

//收藏本站 bbs.ecmoban.com

function AddFavorite(title, url) {

  try {

      window.external.addFavorite(url, title);

  }

catch (e) {

     try {

       window.sidebar.addPanel(title, url, "");

    }

     catch (e) {

         alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");

     }

  }

}</script>
		<!-- 顶部工具条 结束 -->
	<!--logo start-->
	<div class="logo w100">
		<div class="logo_in in_width">
			<h1 class="logo_pic fl"><a href="<?php echo url('index/index'); ?>"><img title="YERSHOP" src="<?php echo C('LOGO'); ?>"  width="201" height="59" /></a></h1>			
			<div class="head-search-layout">
				<div class="head-search-bar" id="head-search-bar">
					
                    <form class="search-form" id="top_search_form" action="<?php echo url('search/index'); ?>" method="post">
						<input name="act" id="search_act" value="search" type="hidden">
          
                        <input name="keyword" id="keyword" type="text" class="input-text ui-autocomplete-input" value="" maxlength="60" x-webkit-speech="" lang="zh-CN" onwebkitspeechchange="foo()" placeholder="请输入您要搜索的商品的关键字" data-value="" x-webkit-grammar="builtin:search" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                        <input type="submit" id="button" value="搜索" class="input-submit">
					
                    </form>
                  	<p>热门搜索:<?php if(is_array($hotsearch) || $hotsearch instanceof \think\Collection || $hotsearch instanceof \think\Paginator): if( count($hotsearch)==0 ) : echo "" ;else: foreach($hotsearch as $key=>$vo): ?><a href="<?php echo url('Search/index?keyword='.$vo); ?>"><?php echo htmlentities($vo); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></p>
				</div>
				
			</div>			
					
			
		</div>
	</div>
	<!--/logo end--> 
	<!--nav start-->
	<div class="nav w100 nav_header">
		<div class="nav_in in_width ">
			<div class="sidebar_div fl">
				<div class="title">
					<i></i>
					<h2 class="f16" id="all-class">全部商品分类</h2>
				</div>
				
				<ul class="left_sidebar" id="all-goods"  style="display:block;">

				<?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($category) ? array_slice($category,0,9, true) : $category->slice(0,9, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<li class="left_sidebar_li">
						<div class="product">
							<div class="border">								
								<div class="fl_div fl"><h3><a href="<?php echo url('Goods/lists?id='.$vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></a></h3>
								</div>
								<span class="fr pic arrow"></span>
							</div>							
						</div>
						<div class="product-wrap f14">
							<div class="menu_div">								
								<div class="sub-class" >
									<div class="sub-class-content">
									
										  <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
										<dl>
											<dt><h3><a href="<?php echo url('Goods/lists?id='.$vo1['id']); ?>"><?php echo htmlentities($vo1['title']); ?></a></h3></dt>
											<dd class="goods-class">
												<?php if(!(empty($vo1['child']) || (($vo1['child'] instanceof \think\Collection || $vo1['child'] instanceof \think\Paginator ) && $vo1['child']->isEmpty()))): if(is_array($vo1['child']) || $vo1['child'] instanceof \think\Collection || $vo1['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo1['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><a href="<?php echo url('Goods/lists?id='.$vo2['id']); ?>"><?php echo htmlentities($vo2['title']); ?></a>
											     <?php endforeach; endif; else: echo "" ;endif; ?><?php endif; ?>
											</dd>
										</dl> <?php endforeach; endif; else: echo "" ;endif; ?>
									</div>
								</div>								
							</div>
						</div>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
					
				</ul>
			</div>			
			<ul class="nav_list fl">
             <?php if(is_array($channel) || $channel instanceof \think\Collection || $channel instanceof \think\Paginator): $i = 0; $__LIST__ = $channel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<li class="fl"><a class="f16" href="<?php echo htmlentities(get_url($vo['url'])); ?>"><?php echo htmlentities($vo['title']); ?></a></li>
				
			<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
	<!--/nav end-->
		<!--banner start-->
	<div class="banner w_100">
		<div class="banner_in in_width">
			<ul class="banner_list">
				<?php if(is_array($slidelist) || $slidelist instanceof \think\Collection || $slidelist instanceof \think\Paginator): $i = 0; $__LIST__ = $slidelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>  
				
				<li class="li_01"><a href="<?php echo htmlentities(get_url($vo['url'])); ?>"><img src="<?php echo htmlentities(get_cover_path($vo['cover_id'])); ?>"/></a>
				
				
				
				</li>
				
              <?php endforeach; endif; else: echo "" ;endif; ?>
			 
			</ul>
			<ol class="banner_ol">
			    <?php if(is_array($slidelist) || $slidelist instanceof \think\Collection || $slidelist instanceof \think\Paginator): $k = 0; $__LIST__ = $slidelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>  
				  <li <?php if($k == 1): ?>class="current"<?php endif; ?>></li>
				  <?php endforeach; endif; else: echo "" ;endif; ?>
			</ol>
			<div class="ads">
			<?php $__LIST__= parseAd(0); if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<a class="f<?php echo htmlentities($i); ?>" href="<?php echo htmlentities(get_url($vo['url'])); ?>"><img alt="" src="<?php echo htmlentities(get_cover_path($vo['cover_id'])); ?>" width="100%" ></a>
				
			<?php endforeach; endif; else: echo "" ;endif; ?></div>
		</div>	
	</div>
	<!--/banner end-->
	<div class="main w100 index_main in_width mofang" style="background:;">
	<h3><img src="/public/index/images/h3.png"/></h3>
	<ul>
	<?php $__LIST__= parseAd(5); if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	<li><a href="<?php echo htmlentities(get_url($vo['url'])); ?>"><img src="<?php echo htmlentities(get_cover_path($vo['cover_id'])); ?>"/></a>
				
				
				
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
	
	</div>
	<!--main start-->
	<div class="main w100 index_main" style="background:;">
		<div class="main_in in_width index_main_in">

			<div class="mid_banner6" style="display:block;height:15px;"></div>
			<?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $k = 0;$__LIST__ = is_array($tree) ? array_slice($tree,0,8, true) : $tree->slice(0,8, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
			<div class="common_list">
				<div class="top">
					<div class="title f14">
						<a href="<?php echo url('Goods/lists?id='.$vo['id']); ?>" class=" f14"> <?php echo htmlentities($vo['title']); ?></a>
						<i class="icon"></i>
					</div>
		                 
				<?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $n = 0;$__LIST__ = is_array($vo['child']) ? array_slice($vo['child'],0,4, true) : $vo['child']->slice(0,4, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$to): $mod = ($n % 2 );++$n;?>
	 <a   href="<?php echo url('Goods/lists?id='.$to['id']); ?>" title="<?php echo htmlentities($to['title']); ?>" href="javascript:vod(0);"  >
    <?php echo htmlentities($to['title']); ?></a>
	<?php endforeach; endif; else: echo "" ;endif; ?> 

				
   		
				</div>
				
				<div class="list_div">
					<div class="lft">
						
						<div class="ad"><a href="<?php echo url('Goods/lists?id='.$vo['id']); ?>" class=" f14"><img src="<?php echo htmlentities(get_cover($vo['cover_id'],'path')); ?>"  /></a></div>
					</div>
					
					<div class="rgt">
						<ul id="list_<?php echo htmlentities($vo['id']); ?>">
						  <?php if(is_array($vo['item']) || $vo['item'] instanceof \think\Collection || $vo['item'] instanceof \think\Paginator): $k = 0; $__LIST__ = $vo['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$article): $mod = ($k % 2 );++$k;?>                      
                            <li <?php if($k == 4 OR $k == 8): ?>class="current"<?php endif; ?>>
                           <div class="pic" >
							<a class="yershop_img" href="<?php echo url('goods/detail?id='.$article['id']); ?>" title="<?php echo htmlentities($article['title']); ?>">
								<img src="<?php echo htmlentities(get_cover($article['cover_id'],'path')); ?>"></a>
						   
						</div>
						<div class="name"><a href="<?php echo url('goods/detail?id='.$article['id']); ?>"  title="<?php echo htmlentities($article['title']); ?>"><?php echo htmlentities($article['title']); ?></a></div>
						<div class="price" style="text-align:center;">
							<font>￥</font><span><?php echo htmlentities($article['price']); ?></span>
						   
						</div>
					   </li>  
				   <?php endforeach; endif; else: echo "" ;endif; ?>
			  
						</ul>
					</div>
				</div>
			</div>	
			 <p class="adimg">
			  <?php if(is_array($vo['brand']) || $vo['brand'] instanceof \think\Collection || $vo['brand'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['brand'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bo): $mod = ($i % 2 );++$i;?> 
			     
				 <span  style="display:inline-block;overflow:hidden;width:<?php echo 1200/count($vo['brand']); ?>px">  <a  href="<?php echo U('goods/lists?brand_id='.$bo['id'].'&id='.$vo['id']); ?>">
                            <img src="<?php echo htmlentities(get_cover($bo['cover_id'],'path')); ?>" width="100%" height=
							"40px"></a></span>
			  <?php endforeach; endif; else: echo "" ;endif; ?></p>	
			  
	         <p>
			  <?php if(is_array($vo['ad']) || $vo['ad'] instanceof \think\Collection || $vo['ad'] instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($vo['ad']) ? array_slice($vo['ad'],0,1, true) : $vo['ad']->slice(0,1, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ao): $mod = ($i % 2 );++$i;?> 
			     
				 <span style="display:inline-block;overflow:hidden;width:100%">  <a  href="<?php echo htmlentities(get_url($ao['url'])); ?>">
                            <img src="<?php echo htmlentities(get_cover($ao['cover_id'],'path')); ?>" width="100%" ></a></span>
			  <?php endforeach; endif; else: echo "" ;endif; ?></p>	

			<?php endforeach; endif; else: echo "" ;endif; ?> 		
			
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


	<script type="text/javascript">
		$(function(){
			//购物车
			$(".mod_minicart").hover(function() {
				$("#nofollow,#minicart_list").addClass("on");
			},function() {
				$("#nofollow,#minicart_list").removeClass("on");
			});
			//nav		
			$('.nav_list li').click(function(e) {
				$(this).addClass('current').siblings().removeClass('current');
			});
			//left_sidebar
			$('.nav_in .left_sidebar .left_sidebar_li').hover(function(){		
				$(this).find('.product').addClass('active')
				$(this).find('.product-wrap').show();
			},function(){
				$(this).find('.product').removeClass('active');
				$(this).find('.product-wrap').hide();

			});
			$('.nav_in .left_sidebar .left_sidebar_li .product-wrap .menu_oneclose').click(function(e) {				
				$(this).parent('.menu_div').parent('.product-wrap').hide();
			});
			
			//分类菜单的显示隐藏                                                                
			var oDiv3 = document.getElementById('all-class');
			var oDiv4 = document.getElementById('all-goods');
			var timer2 = null;//定义定时器变量
			//鼠标移入div1或div2都把定时器关闭了，不让他消失
			oDiv3.onmouseover = oDiv4.onmouseover = function (){	
				oDiv4.style.display = 'block';
				clearTimeout(timer2);
			}

			//鼠标移出div1或div2都重新开定时器，让他延时消失
			oDiv3.onmouseout = oDiv4.onmouseout = function (){
				//开定时器
				timer2 = setTimeout(function () { 
				oDiv4.style.display = 'block'; },300);
			}
			
			//banner
				var banner_len=$('.banner_in .banner_list li').length-1;
				var ol_len=$('.banner_in .banner_ol li').length-1;
				var myFn_01 = function(){
						myOl++;
						if(myOl > banner_len){
							myOl = 0;	
						}
						$('.banner_in .banner_ol li').eq(myOl).addClass('current').siblings().removeClass('current');
						$('.banner_in .banner_list li').eq(myImg).stop().hide();
						myImg++;
						if(myImg > banner_len){
							myImg = 0;	
						}
						$('.banner_in .banner_list li').eq(myImg).stop().show();
					} 
				var myOl = 0;
				var myImg = 0;
				$('.banner_in').hover(function(e) {
					clearInterval(timer02);
				},function(){	
					clearInterval(timer02);
					timer02 = setInterval(myFn_01,3000)
				});	
						
				$('.banner_in .banner_list li').eq(0).show();		
				
				//ol点击
				$('.banner_in .banner_ol li').click(function(e) {
					$(this).addClass('current').siblings().removeClass('current');
					$('.banner_in ul li').eq($(this).index()).stop().show().siblings().stop().hide();
					myOl = $(this).index();
					myImg = $(this).index();
				});
				
				var timer02 = null;
				timer02 = setInterval(myFn_01,4000);
			
			//侧边栏
			$('.nc_appbar .con .kf a').hover(function(){		
				$(this).children('.icon').addClass('cur');
				$(this).children('.tit').show();
			},function(){
				$(this).children('.icon').removeClass('cur');
				$(this).children('.tit').hide();
			});
			$('.nc_appbar .con .gwc a').hover(function(){		
				$(this).children('.icon').addClass('cur');
				$(this).children('.tit').addClass('cur');
			},function(){
				$(this).children('.icon').removeClass('cur');
				$(this).children('.tit').removeClass('cur');
			});
			$('.nc_appbar .con .spdb a').hover(function(){		
				$(this).children('.icon').addClass('cur');
				$(this).children('.tit').show();
			},function(){
				$(this).children('.icon').removeClass('cur');
				$(this).children('.tit').hide();
			});
			$('.nc_appbar .con .dl a').hover(function(){		
				$(this).children('.icon_01').addClass('cur');
				$(this).children('.login_div').show();
			},function(){
				$(this).children('.icon_01').removeClass('cur');
				$(this).children('.login_div').hide();
			});
			$('.to_top').click(function(e) {
				$('body,html').animate({'scrollTop':'0'},500);
			});
			$('.to_top a').hover(function(){		
				$(this).children('.icon').addClass('cur');
				$(this).children('.tit').addClass('cur');
			},function(){
				$(this).children('.icon').removeClass('cur');
				$(this).children('.tit').removeClass('cur');
			});
			
			//li hover_01
			$('.index_main_in .tjsj_con .top_div .rgt_div ul li').hover(function(){		
				$(this).css('opacity','1');
				$(this).siblings().css('opacity','0.8');
			},function(){
				$(this).css('opacity','1');
				$(this).siblings().css('opacity','1');
			});
			//li hover_02
			$('.index_main_in .tjsj_con .bot_div ul li').hover(function(){		
				$(this).find('img').css('opacity','1');
				$(this).siblings().find('img').css('opacity','0.8');
			},function(){
				$(this).find('img').css('opacity','1');
				$(this).siblings().find('img').css('opacity','1');
			});
			
			
			//
			var myFn = function(){
				olKey++;
				if(olKey >2){
					olKey = 0;
				}
				$('.index_main_in .del_con .rgt_div .con_del .lft_ul .tab_ol li').eq(olKey).addClass('current').siblings().removeClass('current');
				imgKey++;
				if(imgKey >3){
					imgKey =1;
					$('.con ul').css('left','0px');	
				}
				var move = imgKey * -348;
				$('.index_main_in .del_con .rgt_div .con_del .lft_ul .conIn ul ').stop().animate({'left':move +'px'},500);			
			}
			
					
				//自动轮播2
			var timer01 = null;
			timer01 = setInterval(myFn,1000);
			$('.index_main_in .del_con .rgt_div .con_del').hover(function(e) {
				clearInterval(timer01);
			},function(){
				clearInterval(timer01);	
				timer01 = setInterval(myFn,1000);
			});
			
			
			var myLi = $('.index_main_in .del_con .rgt_div .con_del .lft_ul .conIn ul li:eq(0)').clone(true);
			var myTag = $(myLi);
			$('.index_main_in .del_con .rgt_div .con_del .lft_ul .conIn ul').append(myTag);
			
			var olKey = 0;
			var imgKey = 0;

				// ol点击
			$('.index_main_in .del_con .rgt_div .con_del .lft_ul .tab_ol li').click(function(e) {
				$(this).addClass('current').siblings().removeClass('current');
				var move = $(this).index() * -348;
				$('.index_main_in .del_con .rgt_div .con_del .lft_ul .conIn ul').stop().animate({'left':move + 'px'},500);
				olKey = $(this).index();
				imgKey = $(this).index();
			});
			
			//li hover_03
			$('.index_main_in .del_con .rgt_div .title ul li').hover(function(){		
				$(this).find('i').css('color','#f19715');
				$(this).siblings().find('i').css('color','#b5b5b5');
			});
			
			$('.index_main_in .del_con .rgt_div .title ul li').click(function(){		
				$(this).find('i').css('color','#f19715');
				$(this).siblings().find('i').css('color','#b5b5b5');
				var this_index =$(this).index();
				$(this).closest('.title').siblings('.con_del').find('.list_01').eq(this_index).addClass('current').siblings().removeClass('current');
			});
			//li hover_04
			$('.index_main_in .del_con .rgt_div .con_del .rgt_ul .list_01 li').hover(function(){		
				$(this).find('img').css('opacity','1');
				$(this).siblings().find('img').css('opacity','0.8');
			},function(){
				$(this).find('img').css('opacity','1');
				$(this).siblings().find('img').css('opacity','1');
			});
		})
	
function getlist(id,pid) {
	$("#category_"+id).addClass('active').siblings().removeClass('active');
	var url="<?php echo url('Index/getGoodlist'); ?>";
	$.post(url, {id:id},function(data){
		 if(data){
				  var html = '';
				 $("ul#list_"+pid).empty(); 		  
				  $.each(data, function(i,n){			
						 var html='<li><div class="pic" > <a class="yershop_img" href="'+n.url+'" target="_blank" title="'+n.title+'"> <img src="'+n.pic+'"width="120" height="120" ></a>  </div> <div class="name"><a href="'+n.url+'"  target="_blank" title="'+n.title
						  +'">'+n.title+'</a></div> <div  class="price">  <font>￥</font><span>'+n.price+'</span></div></li> ';	
					    $("ul#list_"+pid).append(html);
				 });
		}

	})
}

</script>

<script type="text/javascript" charset="utf-8">
  $(function() {
      $("img.lazy").lazyload({effect: "fadeIn"});
  });
</script>

</body>
</html>
