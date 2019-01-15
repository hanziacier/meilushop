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
session_start();
if($_SESSION['error']){ 
			     die('环境检测没有通过，请调整环境后重试！');exit();
			}

?>
	<head>
		<meta charset="utf-8" />
		<title>创建数据库-yershop开源网店系统</title>
	<link type="text/css" href="<?php echo $css;?>/index.css" rel="stylesheet">
	<link type="text/css" href="<?php echo $css;?>/style.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.min.js" ></script>
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
				<div class="steps"><span class="num">4</span>安装
					<span class="arrow"></span>
				</div>
				<div class="steps"><span class="num">5</span>完成
					<span class="arrow"></span>
				</div>
			</div>
			<div class="rule_title">V3.0<span>安装协议</span></div>
			<div class="rules">
	
                
        <h1 style="text-align:center;">创建数据库</h1>
    <form action="step3.php" method="post">
        <div class="item">
            <h2>数据库连接信息</h2>
			<div>数据库连接类型，服务器支持的情况下建议使用mysqli</div>
                <select name="type">
				<option>mysql</option>
                    <option>mysqli</option>
	                  <option>pgsql</option>
                </select>
               
           
          
			    <div>数据库服务器，数据库服务器IP，一般为127.0.0.1</div>
                <input name="hostname" value="127.0.0.1" type="text">
              
          
           
			    <div>数据库名</div>
                <input name="database" value="" type="text">
           
			    <div>数据库用户名</div>
                <input name="username" value="root" type="text">
          
       			<div>数据库密码</div>
                <input name="password" value="" type="password">
               
            
			<div>数据库端口，数据库服务连接端口，一般为3306</div>
                <input name="hostport" value="3306" type="text">
              
           
			   <div>数据表前缀，同一个数据库运行多个系统时请修改为不同的前缀</div>
                <input name="prefix" value="yershop_" type="text">
            
        </div>

        <div class="item">
            <h2>管理员帐号信息</h2>
          
  			    <div>用户名</div>
                <input name="admin[]" value="yershop" type="text">
              
           
			    <div>密码</div>
                <input name="admin[]" value="yershop" type="password">
             
			    <div>确认密码</div>
                <input name="admin[]" value="yershop" type="password">
          
			    <div>邮箱，请填写正确的邮箱便于收取提醒邮件</div>
                <input name="admin[]" value="yershop@qq.com" type="text">
               
           
        </div>
    </form>
			</div>
		    <div class="btn_group">
		    	
		    	<div class="agree">   <a  href="<?php echo $INSTALL_PATH;?>step1.php">上一步</a></div>
		    	<div class="not_agree agree"><a  onclick="submit(this)">下一步</a></div>
		    </div>
		</div>
	</body>
</html>
<script>

function submit(obj){
	//$(".load").show();
	//$(obj).text("安装中,用时约20秒.............");
    $('form').submit();



}


</script>