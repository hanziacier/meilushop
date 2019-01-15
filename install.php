<!DOCTYPE html>
<html><?php
if(version_compare(PHP_VERSION,'5.6.0','<'))  die('require PHP > 5.6.0 !');
$INSTALL_PATH = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']));
if($INSTALL_PATH==="/"){
    $INSTALL_PATH="/";		
}else{
    $INSTALL_PATH= '/'. trim($INSTALL_PATH,'/').'/';
}
define('INSTALL_PATH',$INSTALL_PATH);//安装目录
$css=$INSTALL_PATH.'install/css';//安装目录
if(is_file('../data/install.lock')){
	die('已安装');
	exit;
}
?>
	<head>
		<meta charset="utf-8" />
		<title>安装协议-yershop开源网店系统</title>
	<link type="text/css" href="<?php echo $css;?>/index.css" rel="stylesheet">
	</head>
	<body>
		<div class="border">
			<div class="header">
				<span class="logo6"></span>
				<span class="intro">yershop安装向导</span>
			</div>
			<div class="install_steps">
				<div class="steps  active"><span class="num">1</span>安装协议
					<span class="arrow"></span>
				</div>
				<div class="steps"><span class="num">2</span>环境检测
					<span class="arrow"></span>
				</div>
				<div class="steps"><span class="num">3</span>创建数据库
					<span class="arrow"></span>
				</div>
				<div class="steps"><span class="num">4</span>安装
					<span class="arrow"></span>
				</div>
				<div class="steps"><span class="num">5</span>完成
					<span class="arrow"></span>
				</div>
			</div>
			<div class="rule_title">V3.0<span>安装协议</span></div>
			<div class="rules">
				<br/>
				<div>版权所有 (c) 2014，yershop保留所有权利。</div>
				<div>感谢您选择yershop，yershop诞生于2014年9月，希望我们的努力能为您提供一个简单、强大的站点解决方案。</div>
				<div>用户须知：本协议是您与武汉贝云网络科技有限公司之间关于您使用yershop产品及服务的法律协议。无论您是个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，包括免除或者限制yershop责任的免责条款及对您的权利限制。请您审阅并接受或不接受本服务条款。如您不同意本服务条款及/或yershop随时对其的修改，您应不使用或主动取消yershop产品。否则，您的任何对yershop的相关服务的注册、登陆、下载、查看等使用行为将被视为您对本服务条款全部的完全接受，包括接受武汉贝云网络科技有限公司对服务条款随时所做的任何修改。</div>
				<div>本服务条款一旦发生变更, 武汉贝云网络科技有限公司将在产品官网上公布修改内容。修改后的服务条款一旦在网站公布即有效代替原来的服务条款。您可随时登陆官网查阅最新版服务条款。如果您选择接受本条款，即表示您同意接受协议各项条件的约束。如果您不同意本服务条款，则不能获得使用本服务的权利。您若有违反本条款规定，武汉贝云网络科技有限公司有权随时中止或终止您对yershop产品的使用资格并保留追究相关法律责任的权利。</div>
				<div>在理解、同意、并遵守本协议的全部条款后，方可开始使用yershop产品。您也可能与武汉贝云网络科技有限公司直接签订另一书面协议，以补充或者取代本协议的全部或者任何部分。</div>
				<div>武汉贝云网络科技有限公司拥有yershop的全部知识产权，包括商标和著作权。本软件只供许可协议，并非出售。yershop只允许您在遵守本协议各项条款的情况下复制、下载、安装、使用或者以其他方式受益于本软件的功能或者知识产权。</div>
				<div>I. yershop使用许可的权利、约束与限制</div>
				<br/>
				<ol>
					<li>您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途(包括个人用户：不具备法人资格的自然人，以个人名义从事电子商务开设网店的；非盈利性用途：从事非盈利活动的商业机构及非盈利性组织，将 yershop产品用且仅用于产品演示、展示及发布，而并不是用来买卖及盈利的运营活动的)。</li>
					<li>您可以在协议规定的约束和限制范围内修改 yershop源代码(如果被提供的话)或界面风格以适应您的网站要求。</li>
					<li>您拥有使用本软件构建的商店中全部会员资料、文章、商品及相关信息的所有权，并独立承担与其内容的相关法律义务。</li>
					<li>获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持期限、技术支持方式和技术支持内容，自授权时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。</li>
					<li>未获商业授权之前，不得将本软件用于商业用途(包括但不限于企业法人经营的企业网站、经营性网站、以盈利为目或实现盈利的网站)。</li>
					<li>不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</li>
					<li>无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用 yershop的整体或任何部分，未经书面许可，网站页面页脚处的 yershop名称和yershop(http://www.yershop.com) 的链接都必须保留，而不能清除或修改。</li>
					<li>禁止在yershop的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</li>
					<li>如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。 </li>
				</ol>
			</div>
		    <div class="btn_group">
		    	
		    	<div class="agree">   <a  href="<?php echo $INSTALL_PATH;?>install/step1.php">同意安装协议</a></div>	
				<div class="not_agree agree"><a href="http://yershop.com/" target="_blank">不同意</a</div>
		    	
		    </div>
		</div>
	</body>
</html>
