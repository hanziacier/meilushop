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

defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)));
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
				<span class="logo"></span>
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
				<div class="steps  active"><span class="num">4</span>安装
					<span class="arrow"></span>
				</div>
				<div class="steps"><span class="num">5</span>完成
					<span class="arrow"></span>
				</div>
			</div>
			<div class="rule_title">V3.0<span>安装协议</span></div>
			<div class="rules">
	
                
     <h1>安装</h1>
      <div id="ul-list" >
  
      </div>
	  
	</div>
		    <div class="btn_group">
		    	
		    	<div class="agree">   <a  href="<?php echo $INSTALL_PATH;?>step2.php">上一步</a></div>
		    	<div class="not_agree agree"><a  onclick="$('form').submit()">下一步</a></div>
		    </div>
		</div><script type="text/javascript">
        var list   = document.getElementById('ul-list');
		
         function show_log(log, classname){
            var li = document.createElement('p'); 
            li.innerHTML = log;
            classname && li.setAttribute('class', classname);
            list.appendChild(li);
            document.scrollTop += 30;
        }
       
        
  
      function timer(){ 
	      var url="<?php echo $INSTALL_PATH.'step2.php'; ?>";
	     window.setTimeout(window.location.href=url,18000);
	  }
   
       
        
  
      function success(){ 
	    var url="<?php echo $INSTALL_PATH.'complete.php'; ?>";
	     window.setTimeout(window.location.href=url,18000);
	  }
    </script>	
<?php
       session_start();
      header("Content-type: text/html; charset=utf-8"); 
		if($_SESSION['error']){			
			   $_SESSION['step']= 3;
			   $url=$INSTALL_PATH.'step2.php';
			   echo "<script type='text/javascript'>timer()</script>";
			  
		}
	    if($_SESSION['step']!= 2){
			//$this->redirect('step2');
		} 
		
	 
	        $admin=$_POST['admin'];
			if(!is_array($admin) || empty($admin[0]) || empty($admin[1]) || empty($admin[3])){
			    //die('请填写完整管理员信息');
				echo "<script type='text/javascript'>show_log('请填写完整管理员信息', 'success')</script>";
				exit();
			} else if($admin[1] != $admin[2]){
				//die('确认密码和密码不一致');
				echo "<script type='text/javascript'>show_log('确认密码和密码不一致', 'success')</script>";
				exit();
			} else {
				$info = array();
				list($info['username'], $info['password'], $info['repassword'], $info['email'])
				= $admin;
				
				$_SESSION['admin_info']=$info;
			}
             //print_r($_SESSION['admin_info']);
		    unset($_POST['admin']);
			if(empty($_POST['hostname']) ||  empty($_POST['database']) || empty($_POST['username'])){
				
				echo "<script type='text/javascript'>show_log('请填写完整的数据库配置', 'success')</script>";
				exit();
			} 
		foreach ($_POST as $key=>$value){
				
					$db_config[$key]=$value;
				 
			}
			//print_r( $db_config);
		   //$config= session('db_config');
		   //$db_config=$_SESSION['db_config'];
		     $_SESSION['db_config']= $db_config;
				
	
  $time=time();
  $key="{yershop.com".time()."}";
  if(is_array($db_config)){
		//读取配置内容
		unset($db_config['params']);	
		$conf = file_get_contents(ROOT_PATH . '/data/database.tpl');
		//替换配置项
		foreach ($db_config as $name => $value) {
			$conf = str_replace("[{$name}]", $value, $conf);
		}
		$conf = str_replace('[KEY]', $key, $conf);
		$conf = str_replace('[reg_time]', $time, $conf);
		    //创建数据库连接文件
			if(file_put_contents(ROOT_PATH . '/config/database.php', $conf)){
				echo "<script type='text/javascript'>show_log('数据库连接文件创建成功', 'success')</script>";
	             flush();
	             ob_flush();
			} else {
				echo "<script type='text/javascript'>show_log('数据库连接文件创建失败', 'error')</script>";
	              flush();
	             ob_flush();
			$_SESSION['error']=1;
			}
			//return '';
	}
	
	//读取SQL文件
	$sql = file_get_contents(ROOT_PATH . '/data/install.sql');
	$sql = str_replace("\r", "\n", $sql);
	$sql = explode(";\n", $sql);
	$orginal ="yershop_";
	$prefix=$db_config['prefix'];
	$sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);
	//开始安装
	//print_r($sql);
	//show_log('开始安装数据库...');
  $db =mysqli_connect( $db_config['hostname'], $db_config['username'], $db_config['password']);
  if (!$db) {
     // die('连接数据库出错');
	  echo "<script type='text/javascript'>show_log('连接数据库出错', 'success')</script>";
				exit();
}
echo "<script type='text/javascript'>show_log('连接数据库". $db_config['username']."成功...', 'success')</script>";
	//var_dump($sql);
	echo "<script type='text/javascript'>show_log('开始安装数据库...', 'success')</script>";
	foreach ($sql as $value) {
		$value = trim($value);
		if(empty($value)) continue;
		if(substr($value, 0, 12) == 'CREATE TABLE') {
			$name = preg_replace("/^CREATE TABLE `(\w+)` .*/s", "\\1", $value);
			$msg  = "创建数据表{$name}";
			//$q= $db->query($value);
			//$q=mysql_query($value,$db);
             //var_dump($value);
			 mysqli_select_db($db,$_POST['database']);
			mysqli_query($db,'set names utf8');
			if(mysqli_query($db,$value)){
				//show_log($msg . '...成功');
				echo "<script type='text/javascript'>show_log('".$msg."成功', 'success')</script>";
	             flush();
	             ob_flush();
			} else {
				echo "<script type='text/javascript'>show_log('".$msg."失败', 'success')</script>";
	             flush();
	             ob_flush();	$_SESSION['error']=1;exit();
				//show_log($msg . '...失败！', 'error');
				//session('error', true);
			}
		} else {
			//print_r($value);exit();//$q=$db->query($value);
               mysqli_select_db($db,$_POST['database']);
		    	mysqli_query($db,'set names utf8');
			 mysqli_query($db,$value);

                //echo "<script type='text/javascript'>show_log('失败', 'success')</script>";
	             flush();
	             ob_flush();
		}
	}
	$admin=$_SESSION['admin_info'];
	$password = md5(sha1($admin['password']) . $key);
     $sql = "INSERT INTO `{$prefix}ucenter_member`(username,password,email,reg_time,status,cover_id) VALUES " .
		   "('{$admin['username']}', '{$password}', '{$admin['email']}', '{$time}',  '1','1')";
	mysqli_query($db,'set names utf8');
        if (mysqli_query($db,$sql))
  {
                echo "<script type='text/javascript'>show_log('管理员注册成功', 'success')</script>";
	             flush();
	             ob_flush();
  }
else
  {
                 echo "<script type='text/javascript'>show_log('管理员注册失败', 'success')</script>";
	             flush();
	             ob_flush();
  }
  
			$url=$INSTALL_PATH.'complete.php';
			   echo "<script type='text/javascript'>success()</script>";
		?>
		
		<script type="text/javascript">
      
       
        
  
      function success(){ 
	    var url="<?php echo $INSTALL_PATH.'complete.php'; ?>";
	     window.setTimeout(window.location.href=url,18000);
	  }
    </script>	
	</body>
</html>
