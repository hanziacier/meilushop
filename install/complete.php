<!DOCTYPE html>
<html><?php
header("Content-type: text/html; charset=utf-8"); 
if(version_compare(PHP_VERSION,'5.4.0','<'))  die('require PHP > 5.4.0 !');
$INSTALL_PATH = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']));
if($INSTALL_PATH==="/"){
    $INSTALL_PATH="/";		
}else{
    $INSTALL_PATH= '/'. trim($INSTALL_PATH,'/').'/';
}
define('INSTALL_PATH',$INSTALL_PATH);//安装目录
$css=$INSTALL_PATH.'css';//安装目录
$INSTALL_PATH="http://".$_SERVER['HTTP_HOST'].$INSTALL_PATH;//安装目录
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)));
if(file_put_contents(ROOT_PATH . '/data/install.lock','yer')){
				echo "<script type='text/javascript'>show_log('系统锁定文件创建成功', 'success')</script>";
	             flush();
	             ob_flush();
			} 
?>
	<head>
		<meta charset="utf-8" />
		<title>创建数据库-yershop开源网店系统</title>
<link type="text/css" href="<?php echo $css;?>/index.css" rel="stylesheet">
	<link type="text/css" href="<?php echo $css;?>/style.css" rel="stylesheet">

	</head>
	<body>
		<div class="border">
			<div class="header">
			
				<span class="intro">yershop安装向导</span>
			</div>
			<div class="install_steps">
				<div class="steps  active"><span class="num">1</span>安装协议
					<span class="arrow"></span>
				</div>
				<div class="steps  active"><span class="num">2</span>环境检测
					<span class="arrow"></span>
				</div>
				<div class="steps active"><span class="num">3</span>创建数据库
					<span class="arrow"></span>
				</div>
				<div class="steps active"><span class="num">4</span>安装
					<span class="arrow"></span>
				</div>
				<div class="steps active"><span class="num">5</span>完成
					<span class="arrow"></span>
				</div>
			</div>
			<div class="rule_title">V3.0<span>安装协议</span></div>
			<div class="rules" style="height:300px">
	
                
      <h1>完成</h1>
    <p>安装完成！</p>
			</div>
		    <div class="btn_group">
		    	
		    	<div class="agree">  <a  href="../admin.php">登录后台</a></div>
		    	<div class="not_agree agree"> <a href="../index.php">访问首页</a></div>
		    </div>
		</div>
	</body>
</html>
