<?php /*a:4:{s:62:"/data/wwwroot/yershop/application/index/view/goods/detail.html";i:1547547708;s:63:"/data/wwwroot/yershop/application/index/view/public/header.html";i:1546784250;s:62:"/data/wwwroot/yershop/application/index/view/public/color.html";i:1529863444;s:63:"/data/wwwroot/yershop/application/index/view/public/footer.html";i:1547545240;}*/ ?>
<!-- 头部 -->
	<!doctype html><html lang="zh-cn"><head>	<meta charset="utf-8">	<title><?php if(isset($meta_title)): ?><?php echo htmlentities($meta_title); ?>_<?php endif; ?><?php echo C('WEB_SITE_TITLE'); ?></title>	<link href="/public/index/css/base.css" rel="stylesheet" type="text/css"/><link href="/public/index/css/side.css" rel="stylesheet" type="text/css"/>	<link href="/public/index/css/list.css" rel="stylesheet" type="text/css"/>	<link href="/public/index/css/style.css" rel="stylesheet" type="text/css"/>	<script type="text/javascript" src="/public/common/jquery.min.js"></script>	<script type="text/javascript" src="/public/index/js/base.js"></script>	  </head><body>	<!--header start-->		<!--/header end-->	<div class="top"><div class="topbar">                                 <span class="welcome" style="float:left"><a href="javascript:void(0);" onclick="SetHome(this,'<?php echo root_url(); ?>')">设为首页</a>		<a href="javascript:void(0);" onclick="AddFavorite('<?php echo C('SITENAME'); ?>',location.href)" title="<?php echo C('SITENAME'); ?>">收藏本站</a>		</span> 	  		  <div class="topnav">	 	    <span class="operate_nav">	 			<span  id="userfavor"><a href="<?php echo url('mobile/index/index'); ?>"  ><i></i>手机版&nbsp;</a> </span></span>	<span class="operate_nav"> 			<span  id="sell"><a  href="<?php echo url('help/index?id=6'); ?>" >帮助中心&nbsp;<b></b></a> </span>		    </span>  <span class="operate_nav">	 			<span  id="userfavor"><a  href="<?php echo url('collect/index'); ?>" ><i></i>我的收藏&nbsp;</a> </span></span><span class="operate_nav" >	 <span id="cartbtn" ><a href="<?php echo url('cart/index'); ?>" class="shopping_cart" id="shopping_cart" >购物车</a></span></span>  <span class="operate_nav"> 			<span  id="account"><a  href="<?php echo url('order/index'); ?>" >我的订单&nbsp;</a> </span></span>	<span class="operate_nav" >欢迎光临<?php echo C('SITENAME'); if(is_login()): ?><a href="" class="red"><?php echo get_username(); ?></a>,<a href="<?php echo url('User/logout'); ?>">退出</a><?php else: ?> ,请<a href="<?php echo U('User/login'); ?>" >[登录]</a>&nbsp;<a href="<?php echo url('User/register'); ?>" style="padding-left:0;padding-right:10px"> [免费注册] </a> <?php endif; ?>	</span> </div> </div> </div> <script type="text/javascript">function SetHome(obj,url){    try{        obj.style.behavior='url(#default#homepage)';       obj.setHomePage(url);   }catch(e){       if(window.netscape){          try{              netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");         }catch(e){              alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");          }       }else{        alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");       }  }} //收藏本站 bbs.ecmoban.comfunction AddFavorite(title, url) {  try {      window.external.addFavorite(url, title);  }catch (e) {     try {       window.sidebar.addPanel(title, url, "");    }     catch (e) {         alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");     }  }}</script>		<!-- 顶部工具条 结束 -->	<!--/header end-->		<!--logo start-->	<div class="logo w100">		<div class="logo_in in_width">			<h1 class="logo_pic fl"><a href="<?php echo U('index/index'); ?>"><img title="YERSHOP" src="<?php echo C('LOGO'); ?>" width="201" height="59" /></a></h1>						<div class="head-search-layout">				<div class="head-search-bar" id="head-search-bar">					<div class="hd_serach_tab" id="hdSearchTab">						                    </div>                     <form class="search-form" id="top_search_form" action="<?php echo url('search/index'); ?>" method="post">						<input name="act" id="search_act" value="search" type="hidden">                                  <input name="keyword" id="keyword" type="text" class="input-text ui-autocomplete-input" value="" maxlength="60" x-webkit-speech="" lang="zh-CN" onwebkitspeechchange="foo()" placeholder="请输入您要搜索的商品的关键字" data-value="" x-webkit-grammar="builtin:search" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">                        <input type="submit" id="button" value="搜索" class="input-submit">						<p>热门搜索:<?php if(is_array($hotsearch) || $hotsearch instanceof \think\Collection || $hotsearch instanceof \think\Paginator): if( count($hotsearch)==0 ) : echo "" ;else: foreach($hotsearch as $key=>$vo): ?><a href="<?php echo url('Search/index?keyword='.$vo); ?>"><?php echo htmlentities($vo); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></p>                    </form>                   				</div>							</div>									</div>	</div>	<!--/logo end--> <?php if($action != 'cart/index'): ?>	<!--nav start-->	<div class="nav w100 nav_header">		<div class="nav_in in_width">			<div class="sidebar_div fl">				<div class="title">					<i></i>					<h2 class="f14" id="all-class">全部商品分类</h2>				</div>				<ul class="left_sidebar" id="all-goods">									<?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($category) ? array_slice($category,0,9, true) : $category->slice(0,9, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>					<li class="left_sidebar_li">						<div class="product">							<div class="border">																<div class="fl_div fl"><h3><a href="<?php echo U('Goods/lists?id='.$vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></a></h3>								</div>								<span class="fr pic arrow"></span>							</div>													</div>						<div class="product-wrap f14">							<div class="menu_div">																<div class="sub-class" >									<div class="sub-class-content">										<div class="recommend-class">																				</div>										  <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>										<dl>											<dt><h3><a href="<?php echo U('Goods/lists?id='.$vo1['id']); ?>"><?php echo htmlentities($vo1['title']); ?></a></h3></dt>											<dd class="goods-class">												<?php if(is_array($vo1['child']) || $vo1['child'] instanceof \think\Collection || $vo1['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo1['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Goods/lists?id='.$vo2['id']); ?>"><?php echo htmlentities($vo2['title']); ?></a>											 <?php endforeach; endif; else: echo "" ;endif; ?>											</dd>										</dl> <?php endforeach; endif; else: echo "" ;endif; ?>									</div>								</div>															</div>						</div>					</li><?php endforeach; endif; else: echo "" ;endif; ?>				</ul>			</div>						<ul class="nav_list fl">			  <?php if(is_array($channel) || $channel instanceof \think\Collection || $channel instanceof \think\Paginator): $k = 0; $__LIST__ = $channel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>				<li class="<?php if($current_url == $vo['url']): ?>current<?php endif; ?> fl"><a class="f16"href="<?php echo htmlentities(get_url($vo['url'])); ?>"><?php echo htmlentities($vo['title']); ?></a></li>				<?php endforeach; endif; else: echo "" ;endif; ?>			</ul>		</div>	</div>	<!--/nav end-->	<?php endif; ?>	<script>var del_url="<?php echo url('cart/delItem'); ?>";var post_url="<?php echo url('cart/addItem'); ?>";	var dec_url="<?php echo url('cart/decNum'); ?>";var inc_url="<?php echo url('cart/incNum'); ?>";var img_path="/public/index/images";var order_url="<?php echo url('Order/add'); ?>";var del_cart_url='<?php echo url("cart/delCart"); ?>';var clear_cart_url='<?php echo url("cart/clear"); ?>';var collect_url='<?php echo url("collect/add"); ?>';	//分类菜单的显示隐藏                                                                	var oDiv3 = document.getElementById('all-class');	var oDiv4 = document.getElementById('all-goods');	var timer2 = null;//定义定时器变量	//鼠标移入div1或div2都把定时器关闭了，不让他消失	oDiv3.onmouseover = oDiv4.onmouseover = function (){			oDiv4.style.display = 'block';		clearTimeout(timer2);	}	//鼠标移出div1或div2都重新开定时器，让他延时消失	oDiv3.onmouseout = oDiv4.onmouseout = function (){		//开定时器		timer2 = setTimeout(function () { 		oDiv4.style.display = 'none'; },300);	}</script>
<!-- 头部 --> 
<!--crumb start-->
	<div class="crumb w100 crumb_01">
		<div class="top-bar">
					<ul><li>当前位置：</li>
						<li><a href="<?php echo url('index/index'); ?>">首页</a></li>
						<li> &gt; </li>
					<?php echo get_place($info['category_id']); ?>
						<li>
							<a href="#"> <?php echo htmlentities($info['title']); ?> </a>
						</li>
					</ul>
				</div>
	</div>
	<!--/crumb end-->	
	<!--main start-->
		<script type="text/javascript" src="/public/index/js/jquery.jqzoom.js"></script>
	<script type="text/javascript" src="/public/index/js/lvjing.js"></script>
	<div class="main w100 spxq_main">
		<div class="main_in in_width spxq_main_in">
			<div class="top_div">
				<div class="lft_pic fl">					
					<div id="preview" class="spec-preview"> 
						<span class="jqzoom">
						<img jqimg="<?php echo htmlentities(get_cover($info['cover_id'],'path')); ?>" src="<?php echo htmlentities(get_cover($info['cover_id'],'path')); ?>" width="360"/>
							</span> 
					</div>
					<div class="spec-scroll"> 
						<a class="spec-forward disable">
	<i class="sprite-arrow-prev"><img src="/public/index/images/btn_mobile_prev_cur.jpg"></i>
</a>
<a class="spec-backward">
	<i class="sprite-arrow-next"><img src="/public/index/images/btn_mobile_next_cur.jpg"></i>
</a>
						<div class="items">
							<ul>	
	
							<?php $lists= get_pictures($info['id']); if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): if( count($lists)==0 ) : echo "" ;else: foreach($lists as $k=>$vo): ?> 
								<li><img alt="" bimg="<?php echo htmlentities(get_cover($vo,'path')); ?>" src="<?php echo htmlentities(get_cover($vo,'path')); ?>" onmousemove="preview(this);"></li>
							
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div>
					</div>
					<div class="b_div">
						<a onclick="addClect()" class="sc fl  f12"><i></i>收藏商品<span>(<em><?php echo htmlentities($info['collect']); ?></em>)</span></a>
						<span class=" f12">&nbsp;&nbsp;&nbsp;分享到：<a title="分享到新浪微博" target="_blank" href="http://service.t.sina.com.cn/share/share.php?title=<?php echo htmlentities($info['title']); ?>。（来自<?php echo C('SITENAME'); ?>）&amp;url=<?php echo root_url(); ?><?php echo U('goods/detail?id='.$info['id']); ?>&amp;pic=<?php echo root_url(); ?><?php echo htmlentities(get_cover($info['cover_id'],'path')); ?>" data-item="sina" class="J_vivo_share">
            <img alt="新浪微博" src="/public/index/images/iconfont-weibo.png" app="b2c">        </a>                                                                
        <a title="分享到腾讯微博" target="_blank" href="http://v.t.qq.com/share/share.php?title=<?php echo htmlentities($info['title']); ?>（来自<?php echo C('SITENAME'); ?>）。&amp;url=<?php echo root_url(); ?><?php echo U('goods/detail?id='.$info['id']); ?>&amp;pic=<?php echo root_url(); ?><?php echo htmlentities(get_cover($info['cover_id'],'path')); ?>" data-item="tencent" class="J_vivo_share">
            <img alt="腾讯微博" src="/public/index/images/tengxunweibo.png" app="b2c">        </a>                                                                
        <a target="_blank" title="分享到人人网" href="http://widget.renren.com/dialog/share?resourceUrl=<?php echo root_url(); ?><?php echo U('goods/detail?id='.$info['id']); ?>;srcUrl=<?php echo root_url(); ?>&amp;title=<?php echo htmlentities($info['title']); ?>。（来自<?php echo C('SITENAME'); ?>）&amp;pic=<?php echo root_url(); ?><?php echo htmlentities(get_cover($info['cover_id'],'path')); ?>" data-item="renren" class="J_vivo_share">
            <img alt="人人网" src="/public/index/images/iconfont-renren.png" app="b2c">        </a>           
</span>
						<!--a href="javascript:;" class="share fl"><i></i>分享<span>(<em>0</em>)</span></a> 
						
						<a href="javascript:;" class="compare fl"><i class="sel"></i>加入对比</a>
						<a href="javascript:;" title="举&nbsp;报" class="inform fr">举&nbsp;报</a-->
					</div>
				</div>
				<div class="pro_info fl">
					<h3 class="f16"><a href="javascript:;"><?php echo htmlentities($info['title']); ?></a>  
</h3>
					<div class="price">
						<div class="price_div fl">
							<p class="num_01 f12"><span class="span_l fl">市&nbsp;场&nbsp;价：</span><span class="f12 span_r fl">¥<?php echo htmlentities($info['price']); ?></span></p>
							<p class="num_02 f12"><span class="span_l fl">商&nbsp;城&nbsp;价：</span><span class="span_r fl">¥<?php echo htmlentities($sku2['price']); ?></span> 
						</p>
							<div class="num_03 f12">
								<span class="span_l fl"> 商品评分：</span>
								<div class="star fl icon_0<?php echo htmlentities(getEqual($info['id'])); ?>"></div>
								<a href="javascript:;" class="pl_num fl">共有<?php echo htmlentities($comment['count']); ?>条评论</a>
							</div>
						</div>
						<div class="fr code f12">
							<div class="pic" id="code"></div>
							<script type="text/javascript" src="/public/common/jquery.qrcode.min.js"></script>
							<p>手机端扫购有惊喜</p>
                             <SCRIPT>$("#code").qrcode({ 
    render: "table", //table方式 
    width: 88, //宽度 
    height:88, //高度 
    text: "<?php echo root_url(); ?><?php echo url('mobile/goods/detail?id='.$info["id"]); ?>" //任意内容
}); </SCRIPT>
						</div>
					</div>
					<div class="ps f12" style="width:620px;padding:10px 0px;">
						<ul id="list1" >
	<li id="summary-stock">
		<div class="dt">配&nbsp;送&nbsp;至：</div>
		<div class="dd">
			<div id="arealist">
				<div class="text">湖北省 武汉市 武昌区<div></div><b></b></div><span class="yh">有货  </span>
				<div class="content"><div data-widget="tabs" class="m ul-list" id="ul-list"><div class="mt">  
				<ul class="tab">        
				<li data-index="0" data-widget="tab-item" class="curr"><a href="#none" class="hover"><em>湖北</em><i></i></a></li>       
				<li data-index="1" data-widget="tab-item" style="display: list-item;" class=""><a href="#none" class=""><em>武汉市</em><i></i></a></li>      
				<li data-index="2" data-widget="tab-item" style="display: list-item;" ><a href="#none" class=""><em>请选择</em><i></i></a></li>       
				<li data-index="3" data-widget="tab-item" style="display:none;"><a href="#none" class=""><em>请选择</em><i></i></a></li>    
				</ul>    <div class="stock-line"></div></div>
				
				<div class="mc" data-area="0" data-widget="tab-content" id="stock_province_item" style="display: ;">    <ul class="area-list">   
				<?php if(is_array($arealist) || $arealist instanceof \think\Collection || $arealist instanceof \think\Paginator): $i = 0; $__LIST__ = $arealist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<li><a href="#none" data-value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></a>
				</li>
				<?php endforeach; endif; else: echo "" ;endif; ?> 
				</ul></div>
				
				<div class="mc" data-area="1" data-widget="tab-content" id="stock_city_item" style="display: none;"><ul class="area-list">
				<li><a href="#none" data-value="275">衡水市</a></li>
				
				</ul>
				
				</div>
				
				<div class="mc" data-area="2" data-widget="tab-content" id="stock_area_item" style="display:none ;">
				<div class="iloading">正在加载中，请稍候...</div></div>
				
				<div class="mc" data-area="3" data-widget="tab-content" id="stock_town_item" style="display: none;"></div></div>
				
				</div>
				<div onclick='$("#arealist .content, #arealist .close,#ul-list").hide();' class="close"></div>
			</div><!--store-selector end-->
			<div id="store-prompt"><strong></strong></div><!--store-prompt end--->
		</div>
	</li>
</ul>
<script>$(".spec-scroll .spec-backward").click(function(){
				if($(this).hasClass("disable")){
					return false;
				}
         })	
		
var areaTabContainer=$("#ul-list .tab li");
var provinceContainer=$("#stock_province_item");
var cityContainer=$("#stock_city_item");
var areaContainer=$("#stock_area_item");
var townaContainer=$("#stock_town_item");
var currentDom = provinceContainer;

(function(){
	$("#arealist").find(".text").bind("click",function(){
		$('#arealist').addClass('hover');
		$("#arealist .content, #arealist .close,#ul-list").show();
	}).find("dl").remove();
	
	areaTabContainer.eq(0).find("a").click(function(){
		areaTabContainer.removeClass("curr");
		areaTabContainer.eq(0).addClass("curr").show();
		provinceContainer.show();
		cityContainer.hide();
		areaContainer.hide();
		townaContainer.hide();
		areaTabContainer.eq(1).hide();
		areaTabContainer.eq(2).hide();
		areaTabContainer.eq(3).hide();
	});
	areaTabContainer.eq(1).find("a").click(function(){
		areaTabContainer.removeClass("curr");
		areaTabContainer.eq(1).addClass("curr").show();
		provinceContainer.hide();
		cityContainer.show();
		areaContainer.hide();
		townaContainer.hide();
		areaTabContainer.eq(2).hide();
		areaTabContainer.eq(3).hide();
	});
	areaTabContainer.eq(2).find("a").click(function(){
		areaTabContainer.removeClass("curr");
		areaTabContainer.eq(2).addClass("curr").show();
		provinceContainer.hide();
		cityContainer.hide();
		areaContainer.show();
		townaContainer.hide();
		areaTabContainer.eq(3).hide();
	});
	provinceContainer.find("a").click(function() {
		
		
		chooseProvince($(this).attr("data-value"),$(this).text());
	}).end();
	//chooseProvince(currentAreaInfo.currentProvinceId);
})();

var page_load;
function chooseProvince(pid,title){
	provinceContainer.hide();
	
	areaTabContainer.eq(0).removeClass("curr").find("em").html(title);
	areaTabContainer.eq(1).addClass("curr").show().find("em").html("请选择");
	areaTabContainer.eq(2).hide();
	areaTabContainer.eq(3).hide();
	cityContainer.show();
	cityContainer.show().html("<div class='iloading'>正在加载中，请稍候...</div>");
	$.post('<?php echo U("address/change"); ?>',{pid:pid},function(data,textStatus){
						if(data){
						   var html = '<ul class="area-list" >';
                       
								$.each(data, function(i,n){
									  html = html+'<li><a data-value="'+$(this)[0]['id']
									  +'" onclick="chooseCity(this,'+$(this)[0]['id']+')">'+
									  $(this)[0]['title']+'</a></li>';
								
							});
							html +=  '</ul>';
							cityContainer.html(html);
						}else{
							alert('没有子级了!');
						}
		  });
	areaContainer.hide();
	townaContainer.hide();
	

}

function chooseCity(obj,pid){
	provinceContainer.hide();
	cityContainer.hide();
	areaContainer.hide();
	areaTabContainer.eq(1).removeClass("curr").find("em").html($(obj).html());
	areaTabContainer.eq(2).addClass("curr").show().find("em").html("请选择");
	townaContainer.show().html("<div class='iloading'>正在加载中，请稍候...</div>");
	$.post('<?php echo U("address/change"); ?>',{pid:pid},function(data,textStatus){
						if(data){
						   var html = '<ul class="area-list" >';
                       
								$.each(data, function(i,n){
									 html = html+'<li><a data-value="'+$(this)[0]['id']
									  +'" onclick="chooseArea(this,'+$(this)[0]['id']+')">'+
									  $(this)[0]['title']+'</a></li>';
								
							});
							html +=  '</ul>';

							townaContainer.html(html);
						}else{
							alert('没有子级了!');
						}
		  });
	currentDom = townaContainer;
	
	
}
function chooseArea(obj,pid){
	
	areaTabContainer.eq(2).removeClass("curr").find("em").html($(obj).html());
	$(".text").html(areaTabContainer.eq(0).text()+" &nbsp;"+areaTabContainer.eq(1).text()+" &nbsp;" +areaTabContainer.eq(2).text()+" <b></b>");
	$("#arealist .content, #arealist .close").hide();
	
	
}
				</script>	

					</div>
					 <?php if(!(empty($attrlist) || (($attrlist instanceof \think\Collection || $attrlist instanceof \think\Paginator ) && $attrlist->isEmpty()))): if(is_array($attrlist) || $attrlist instanceof \think\Collection || $attrlist instanceof \think\Paginator): $i = 0; $__LIST__ = $attrlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<div class="caizhi f12">
						<label class="fl"><?php echo htmlentities($vo['title']); ?>：</label>
						<ul class="sel_ul">
							<?php if(is_array($vo['sid']) || $vo['sid'] instanceof \think\Collection || $vo['sid'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['sid'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
							  <li class="<?php if($i == 1): ?>current<?php endif; ?>" attr_id="<?php echo htmlentities($vo1['id']); ?>">
								<span class="txt fl"><?php echo htmlentities($vo1['title']); ?></span>
								<span class="icon"></span>
							  </li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					  </div>	
					<?php endforeach; endif; else: echo "" ;endif; ?><?php endif; ?>
					<div class="num_input">
						<div class="ipt_l fl">
							<input type="text"  class="fl f16" id="num_ipt" onkeyup="value=value.replace(/[^\d]/g,'');javascript:this.value.substring(0,1)=='0'?this.value='0':this.value=this.value" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" maxlength="2"/>
							<div class="fl btn">
								<div class="jia"><span></span></div>
								<div class="jian"><span></span></div>
							</div>
						</div>						
						<a onclick="addCart()"class="fl jr f18"><span></span>加入购物车</a>
						<a onclick="orderCreate()" class="fl buy f18">立即购买</a>
					</div>
				</div>
				<div class="left_klyk fl">
					<div class="left_klyk_pd">
					    <fieldset>
					        <legend>看了又看</legend>
					    </fieldset>
					    <ul class="left_klyk_list">
					    	<?php if(is_array($see_list) || $see_list instanceof \think\Collection || $see_list instanceof \think\Paginator): $i = 0; $__LIST__ = $see_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							<li>
					    		<a href="<?php echo url('goods/detail?id='.$vo['id']); ?>"><img src="<?php echo htmlentities(get_cover($vo['cover_id'],'path')); ?>"/></a>
					    		<a href="<?php echo url('goods/detail?id='.$vo['id']); ?>" class="klyk_img_mask">￥<?php echo htmlentities($vo['price']); ?></a>
					    	</li>
					    	<?php endforeach; endif; else: echo "" ;endif; ?>
					    </ul>
					</div>
				</div>
			</div>
			<script type="text/javascript" src="/public/index/js/jquery.lazyload.js"></script>
			<div class="details">
				<div class="lft_pan f12 fl">					
					
					<div class="klyk">
						<h3 class="title f14">推荐商品</h3>
						<ul class="list_ul">
						<?php if(is_array($rexiao) || $rexiao instanceof \think\Collection || $rexiao instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($rexiao) ? array_slice($rexiao,0,6, true) : $rexiao->slice(0,6, true); if( count($__LIST__)==0 ) : echo "暂无数据" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						   <li>
								<a href="<?php echo url('goods/detail?id='.$vo['id']); ?>" class="pic"><img class="lazy" data-original="<?php echo htmlentities(get_cover($vo['cover_id'],'path')); ?>" /></a>
								<a href="<?php echo url('goods/detail?id='.$vo['id']); ?>" class="tit f12"><?php echo htmlentities($vo['title']); ?></a>
								<p class="price f18">¥<?php echo htmlentities($vo['price']); ?></p>
							</li>
					     <?php endforeach; endif; else: echo "暂无数据" ;endif; ?>
						</ul>
					</div>
					
					<script type="text/javascript" charset="utf-8">
					  $(function() {
						  $("img.lazy").lazyload({effect: "fadeIn"});
					  });
					</script>
				</div>
				<div class="rgt_pan f14 fr">
					<div class="tit f14">
						<ul>
							<li class="current"><a href="javascript:;">商品详情</a></li>
							<li><a href="javascript:;">商品评价<span>（<?php echo htmlentities($comment['count']); ?>）</span></a></li>
							<li><a href="javascript:;">销售记录<span>（<?php echo htmlentities($sales['count']); ?>）</span></a></li>
							<li><a href="javascript:;">售后保障</a></li>
						</ul>
					</div>					
					<div class="spxq_con rgt_pan_con" style="display:block;">
						<br />
						<div class="info_01 f12">
							<ul>
							<?php if(is_array($basic) || $basic instanceof \think\Collection || $basic instanceof \think\Paginator): $i = 0; $__LIST__ = $basic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							  <li></li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
								
								
							</ul>
						</div>
						<div class="info_02">
							<?php echo $info['content']; ?>
						</div>												
						
					</div>
					<div class="sppj_con rgt_pan_con" style="display:none;">
							<br /><div class="mt">
                       <h3>商品评价</h3>
                    </div>
						<div class="spms">
							<div class="div_l fl">
								<p class="txt f12">与描述相符</p>
								<p class="num"><?php echo htmlentities(getEqual($info['id'])); ?></p>
								<div class="star star_0<?php echo htmlentities(getEqual($info['id'])); ?>"></div>
							</div>
							<div class="div_r fl">
								<p class="txt fl">大<br />家<br />都<br />写<br />到</p>
								<span class="kh fl"></span>
								<ul class="list fl">
									 <?php if(is_array($tags) || $tags instanceof \think\Collection || $tags instanceof \think\Paginator): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>  
									<li><a ><?php echo htmlentities($vo['title']); ?>（<?php echo htmlentities($vo['num']); ?>）</a></li>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
								<div class="sel_div cl fr"><span></span></div>
							</div>
						</div>
						<div class="pj_list">
							<div class="tit_sel f12">
								<ul class="ul_l fl">
									<li>
										<input type="radio" name="all" checked="checked" onclick="comments()"/>
										<label for="">全部</label>
									</li>
									<li>
										<input type="radio" name="is_over"  onclick="comment()"/>
										<label for="">追评（<?php echo htmlentities($comment["is_over_count"]); ?>）</label>
									</li>
									<li>
										<input type="radio" name="is_picture" onclick="comment()"/>
										<label for="">图片（<?php echo htmlentities((isset($comment["is_picture_count"]) && ($comment["is_picture_count"] !== '')?$comment["is_picture_count"]:"0")); ?>）</label>
									</li>
								</ul>
								<div class="div_r fr">
									<div class="nr fl">
										<input type="checkbox" name="notempty"  onclick="comment()"/>
										<label for="">有内容 </label>
									</div>
									<div class="xl fl">
										<div class="show">按默认 <span></span></div>
										<div class="xl_list" onclick="comment()">按时间</div>
									</div>
								</div>
							</div>
								  <script type="text/javascript">
		     
           
           
   </script>
							<div class="list_del f12">
								<ul class="list_ul" id="comments">
									
									<?php if(is_array($comment['list']) || $comment['list'] instanceof \think\Collection || $comment['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $comment['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
									<li class="list_li">
										<div class="div_l fl">
											<p class="txt_01"><?php echo htmlentities((isset($vo['message']) && ($vo['message'] !== '')?$vo['message']:"")); ?></p>
											<ul class="pic">
												<?php if(is_array($vo['pictures']) || $vo['pictures'] instanceof \think\Collection || $vo['pictures'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['pictures'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
							                   <li> <img  src="<?php echo htmlentities(get_cover($vo1,'path')); ?>" width="40" height="40"/></li>
						                    <?php endforeach; endif; else: echo "" ;endif; ?>
												
											</ul>
											<p class="time"><?php echo htmlentities(time_format($vo['create_time'])); ?></p>
											<p class="jieshi"><?php echo htmlentities((isset($vo['reply']) && ($vo['reply'] !== '')?$vo['reply']:"")); ?></p>
										</div>
										<div class="div_r fr"><?php echo htmlentities(get_username($vo['uid'])); ?>（匿名）</div>
									</li>
									<?php endforeach; endif; else: echo "" ;endif; ?>
									 <div class="comment">
									     <?php echo htmlentities($comment['page']); ?>
								 </div>
									     
									  	
									   
									   
		                         <script type="text/javascript">
		                              var goodsid="<?php echo htmlentities($info['id']); ?>";
									  //分页
       $(".comment a").click(function(event) {
            event.preventDefault();
            event.stopPropagation(); // 阻止冒泡
			var Regx = /page\=(\d)/g; 
			var url=$(this).attr("href");
		
           	var str= url.match(Regx);	
			var str=str.toString();
			var page=str.substring(5);
			comment(page);
       });	
       function comment(p){    //user函数名 一定要和action中的第三个参数一致上面有
                  var url="<?php echo url('goods/comment'); ?>"; 
									   if($("input[name='is_over']").is(':checked')) {
                                         var is_over=1;
                                       }
									   if($("input[name='is_picture']").is(':checked')) {
                                         var is_picture=1;
                                       }
									   if($("input[name='not_empty']").is(':checked')) {
                                         var not_empty=1;
                                       }
 $.post(url, {page:p,goodsid:goodsid,is_over:is_over,is_picture:is_picture,not_empty:not_empty,type:1}, function(data){  //用get方法发送信息到UserAction中的user方法
                                          $("#comments").html(data);; //user一定要和tpl中的一致
                });
                                     }
           
                                </script>
	    
						 </ul>	
								
							</div>
						</div>
						
					</div>
					<div class="xsjl_con rgt_pan_con" style="display:none;">
						<br />
						<div class="f12 scj">
							<p class="prcie fl">商&nbsp;&nbsp;城&nbsp;&nbsp;价<span><?php echo htmlentities($info['price']); ?></span>元</p>
							<span class="tip fl">购买的价格不同可能是由于店铺往期促销活动引起的，详情可以咨询卖家</span>
						</div>
						<div class="zx_list f12">
							<div class="title_list">
								<span class="span_01 fl">买家</span>
								<span class="span_02 fl">购买价</span>
								<span class="span_03 fl">优惠活动</span>
								<span class="span_04 fl">购买数量</span>
								<span class="span_05 fl">购买时间</span>
							</div>
							<div class="xx_list" id="sales">
								<?php if(is_array($sales['list']) || $sales['list'] instanceof \think\Collection || $sales['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $sales['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
								<div class="list_div">
									<span class="span_01 fl"><?php echo htmlentities(get_username($vo['uid'])); ?></span>
									<span class="span_02 fl">¥<?php echo htmlentities((isset($vo['price']) && ($vo['price'] !== '')?$vo['price']:"")); ?></span>
									<span class="span_03 fl"><?php echo htmlentities((isset($vo['cuxiao']) && ($vo['cuxiao'] !== '')?$vo['cuxiao']:"无")); ?></span>
									<span class="span_04 fl"><?php echo htmlentities((isset($vo['num']) && ($vo['num'] !== '')?$vo['num']:"")); ?></span>
									<span class="span_05 fl"> <?php echo htmlentities(time_format($vo['create_time'])); ?></span>
								</div>
						       <?php endforeach; endif; else: echo "" ;endif; ?>
								 <div class="sales">
									      <?php echo htmlentities($sales['page']); ?>
								 </div>
	     <script type="text/javascript">
		                              var goodsid="<?php echo htmlentities($info['id']); ?>";
									  //分页
       $(".sales a").click(function(event) {
            event.preventDefault();
            event.stopPropagation(); // 阻止冒泡
			var Regx = /page\=(\d)/g; 
			var url=$(this).attr("href");
		
           	var str= url.match(Regx);	
			var str=str.toString();
			var page=str.substring(5);
			sales(page);
       });	
       function sales(p){    //user函数名 一定要和action中的第三个参数一致上面有
                  var url="<?php echo url('goods/sales'); ?>"; 
									  
 $.post(url, {page:p,goodsid:goodsid}, function(data){  //用get方法发送信息到UserAction中的user方法
                                          $("#sales").html(data);; //user一定要和tpl中的一致
                });
                                     }
           
                                </script>
								 
							</div>
							
						</div>
					</div>
					<div class="gmzx_con rgt_pan_con" style="display:none;">
						<br />
					<div class="mt">
                       <h3>售后保障</h3>
                    </div>	
<div class="serve-agree-bd">
    <dl style="text-indent:2em;">
                <dt>
            <i class="icon"></i>
            <strong>厂家服务</strong>
        </dt>
        <dd>
                本产品全国联保，享受三包服务，质保期为：全国联保二年<br>
              自收到商品之日起，如您所购买家电商品出现质量问题，请先联系厂家进行检测，凭厂商提供的故障检测证明，在“我的商城-客户服务-返修退换货”页面提交退换申请，将有专业售后人员提供服务。商城承诺您：30天内产品出现质量问题可退货，180天内产品出现质量问题可换货，超过180天按国家三包规定享受服务。
                                                                                            </dd>

                <dt>
            <i class="icon"></i>
            <strong>商城承诺</strong>
        </dt>
        <dd>
                            商城平台卖家销售并发货的商品，由平台卖家提供发票和相应的售后服务。请您放心购买！<br>
                                        注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！
        </dd>

                <dt>
            <i class="icon"></i><strong>正品行货</strong>
        </dt>
                        <dd>商城商城向您保证所售商品均为正品行货，商城自营商品开具机打发票或电子发票。</dd>
                                <dt><i class="unprofor"></i><strong>全国联保</strong></dt>
        <dd>
            凭质保证书及商城商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由商城联系保修，享受法定三包售后服务），与您亲临商场选购的商品享受相同的质量保证。商城商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！
            <br><br>注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！
        </dd>
             
            </dl>
</div>
				
						</div>
					</div>
	
				</div>
			</div>			
		</div>
	</div>
	 <div id="flyItem" class="fly_item"><img src="<?php echo htmlentities(get_cover_path($info['cover_id'])); ?>" width="40" height="40"></div>

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
			</div>
		</div>
	</div>
	<!--/footer  end-->
	<span class="copyright" style="">@2014-2017
	   <a href="">meilu</a> 版权所有</span>
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
	   var goodsid="<?php echo htmlentities($info['id']); ?>";
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
				var result = new Array(); 
			 //var ids=$(".caizhi .current");
                $(".caizhi .current").each(function () {
                        result.push($(this).attr("attr_id"));

                });

               if(result){
			       var id=result.sort(sortNum);
				}
				var path=result.join(",");
				var show_url="<?php echo url('showprice'); ?>";
				  $.getJSON(show_url,{path:path,goodsid:goodsid},function(data){
                     $(".num_02 .span_r").text("¥"+data.price);
                 });

				
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
	//左右滚动
			//向前按钮点击
			$(".spec-scroll .spec-forward").click(function(){
				if($(this).hasClass("disable")){
					return false;
				}
				var reg = /\d+/;
				var marleft = parseInt($(".spec-scroll .items ul").css("margin-left").match(reg)[0]);
				var nums = $(".spec-scroll .items ul li").length;
				if(nums <= 4){
					$(".spec-scroll .spec-backward").addClass("disable");
					$(this).addClass("disable");
					return false;
				}
				var totallen = nums * (72);
				var setLeft = 0;
				
				if((marleft - 288) <= 0){
					setLeft = 0;
					$(this).addClass("disable");
				}else{
					setLeft = -(marleft - 288);
				}
				$(".spec-scroll .spec-backward").removeClass("disable");
				$(".spec-scroll .items ul").animate({
					"margin-left":setLeft + "px"
				});
			});
			//向后按钮点击
			$(".spec-scroll .spec-backward").click(function(){
				if($(this).hasClass("disable")){
					return false;
				}
				var reg = /\d+/;
				var marleft = parseInt($(".spec-scroll .items ul").css("margin-left").match(reg)[0]);
				var nums = $(".spec-scroll .items ul li").length;
				
				if(nums <= 4){
					$(".spec-scroll .spec-forward").addClass("disable");
					$(this).addClass("disable");
					return false;
				}
				
				var totallen = nums * (72);
				var setLeft = 0;
				
				if((marleft + 576) >= totallen){
					setLeft = -(totallen - 288);
					$(this).addClass("disable");
				}else{
					setLeft = -marleft - 288;
				}
				$(".spec-scroll .spec-forward").removeClass("disable");
				$(".spec-scroll .items ul").animate({
					"margin-left":setLeft + "px"
				},1000);
			});

		
         function consult(p,type){    //user函数名 一定要和action中的第三个参数一致上面有
                  
                    $.get('<?php echo url("goods/consult"); ?>', {p:p,goodsid:goodsid,type:type}, function(data){  //用get方法发送信息到UserAction中的user方法
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
					      //opensuccess(data);
					
					      if(data.isin>0){
					          $('.span_r').text("¥"+data.price);
						      $('.item_num_'+data.sku_id).text(data.num); 
					     }
                         else{					
						    $('#carthtml').append(data.tpl);
					    } 
						$('.spxq_tc').show(); 
						$('.tNum').text(data.count);
						$('.cart_num').text(data.sum);
						$('.num'+data.sku_id).text(data.num);
						$('.tSum').text("¥"+data.total);
                       addpaowuxian();
					 }
					 else{
					    openerror(data);
					 
					 }
                });
		   
		}   
		function orderCreate(){
		     var result = new Array(); 
			 //var ids=$(".caizhi .current");
                $(".caizhi .current").each(function () {
                        result.push($(this).attr("attr_id"));

                });
                var login="<?php echo is_login(); ?>";
				if(login<1){
					showBg();return false;
				}
               if(result){
			       var id=result.sort(sortNum);
				}
				var id=result.join(",");
				var num=$("#num_ipt").val();
				var order_url="<?php echo url("order/create"); ?>";
		       $.post(order_url,{path:id,goodsid:goodsid,num:num},function(data){
                     
					 if(data.code){  
					     if (data.url) {
                            location.href=data.url;
                         }
					 }
					 else{
					    openerror(data);
					 }
                });
		}
		function addClect(){
		     
				var order_url="<?php echo url('collect/add'); ?>";
		        $.post(order_url,{id:goodsid},function(data){
                     
					 if(data.code){  
					     opensuccess(data);
					 }
					 else{
					     openerror(data);
					 }
                });
		} 
	$(".mask .alert_div .alert_close").click(function(){
			    $(this).parents(".mask").addClass("none");
			});
			$(".mask .alert_div .alert_btn").click(function(){
			    $(this).parents(".mask").addClass("none");
			});
			$(".tjpj").click(function(){
				  opensuccess();
			})
		
   </script>
   </div>
</body>
</html>
