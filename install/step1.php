<!DOCTYPE html>
<html><?php
header("Content-type: text/html; charset=utf-8"); 
if(version_compare(PHP_VERSION,'5.4.0','<'))  die('require PHP > 5.4.0 !');
$INSTALL_PATH = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']));
if($INSTALL_PATH==="/"){
    $INSTALL_PATH="/";		
}else{
    $INSTALL_PATH= '/'. trim($INSTALL_PATH,'/').'/';
}defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)));
//echo ROOT_PATH;
define('INSTALL_PATH',$INSTALL_PATH);//安装目录
$css=$INSTALL_PATH.'css';//安装目录
	//环境检测
	$config = array(
		array('操作系统', '不限制', '类Unix', PHP_OS, 'success'),
		array('PHP版本', '5.4', '5.4+', PHP_VERSION, 'success'),
		array('MYSQL版本', '5.0', '5.0+', '未知', 'success'), //PHP5.5不支持mysql版本检测
		array('附件上传', '不限制', '2M+', '未知', 'success'),
		array('GD库', '2.0', '2.0+', '未知', 'success'),
		array('磁盘空间', '50M', '不限制', '未知', 'success'),
	);
session_start();$_SESSION['error']=0;
	//PHP版本检测
	if(PHP_VERSION < 5.4){
		$config[1][4] = 'error';
		$_SESSION['error']=1;
	}

	//数据库检测
	// if(function_exists('mysql_get_server_info')){
		//$config[2][3] = mysql_get_server_info();
 	// if($config[2][3] < $config[2][1]){
 		//$config[2][4] = 'error';
			//$_SESSION['error']=1;
		//}
	// }

	//附件上传检测
	if(@ini_get('file_uploads'))
		$config[3][3] = ini_get('upload_max_filesize');

	//GD库检测
	$tmp = function_exists('gd_info') ? gd_info() : array();
	if(empty($tmp['GD Version'])){
		$config[4][3] = '未安装';
		$config[4][4] = 'error';
		$_SESSION['error']=1;
	} else {
		$config[4][3] = $tmp['GD Version'];
	}
	unset($tmp);
define('REAL_PATH', realpath('./') . '/');
	//磁盘空间检测
	if(function_exists('disk_free_space')) {
		$config[5][3] = floor(disk_free_space(REAL_PATH) / (1024*1024)).'M';
	}
    $functions= $config;
	
		//目录文件读写检测
		
     unset($config);
		//函数检测
	$config = array(
	    array('dir',  '[√]可写', 'success', '../application'),
		array('dir',  '[√]可写', 'success', '../public/uploads/attachment'),
		array('dir',  '[√]可写', 'success', '../public/uploads/download'),
		array('dir',  '[√]可写', 'success', '../public/uploads/picture'),
		array('dir',  '[√]可写', 'success', '../public/uploads/editor'),
		array('dir',  '[√]可写', 'success', '../public/uploads/media'),
		array('dir',  '[√]可写', 'success', '../public/uploads/QRcode'),
		array('dir',  '[√]可写', 'success', '../runtime'),
		array('dir',  '[√]可写', 'success', '../data'),
		
	);

	foreach ($config as &$val) {
		if('dir' == $val[0]){
			if(!is_writable(REAL_PATH . $val[3])) {
				if(is_dir($val[3])) {
					$val[1] = '<span>[√]可读</span>';
					$val[2] = 'error';
					$_SESSION['error']=1;
				} else {
					$val[1] = '<span style="color:#f30">[×]不存在</span>';
					$val[2] = 'error';
					$_SESSION['error']=1;
				}
				
			}
		} else {
			if(file_exists(REAL_PATH . $val[3])) {
				if(!is_writable(REAL_PATH . $val[3])) {
					$val[1] = '<span style="color:#f30">[×]不可写</span>';
					$val[2] = 'error';
					$_SESSION['error']=1;
				}
			} else {
				if(!is_writable(dirname(REAL_PATH . $val[3]))) {
					$val[1] = '<span style="color:#f30">[×]不存在</span>';
					$val[2] = 'error';
					$_SESSION['error']=1;
				}
			}
		}
	}
	
		$files= $config;
		$_SESSION['step']=1;
        unset($config);
	    $config = array(
	
		array('file_get_contents', '[√]支持', 'success'),
		array('mb_strlen',		   '[√]支持', 'success'),
	);

	foreach ($config as &$val) {
		if(!function_exists($val[0])){
			$val[1] = '<span style="color:#f30">[×]不支持</span>';
			$val[2] = 'error';
			$val[3] = '开启';
			$_SESSION['error']=1;
		}
	}
	
	$func=$config;


?>
	<head>
		<meta charset="utf-8" />
		<title>环境检测-yershop开源网店系统</title>
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
			 <h1 style="text-align:center;">环境检测</h1>
       <table class="table">
        <caption><h2>运行环境检查</h2></caption>
        <thead>
            <tr>
                <th>项目</th>
                <th>所需配置</th>
                <th>当前配置</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($functions as $item=>$v) {  ?>
				<tr>
                    <td><?php echo $v[0];?></td>
                    <td><?php echo $v[1];?></td>
                    <td><i class="ico-{$item[4]}">&nbsp;</i><?php echo $v[3];?></td>       
                </tr>
         <?php } ?>
        </tbody>
    </table>
	
    <table class="table">
        <caption><h2>目录、文件权限检查</h2></caption>
        <thead>
            <tr>
                <th>目录/文件</th>
                <th>所需状态</th>
                <th>当前状态</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($files as $item=>$v) {  ?>
                <tr>
                    <td><?php echo $v[3];?></td>
                    <td><i class="ico-success">&nbsp;</i>可写</td>
                    <td><i class="ico-{$item[2]}">&nbsp;</i><?php echo $v[1];?></td>   
                </tr>
   <?php } ?>
        </tbody>
    </table>
	
    <table class="table">
        <caption><h2>函数依赖性检查</h2></caption>
        <thead>
            <tr>
                <th>函数名称</th>
                <th>检查结果</th>
            </tr>
        </thead>
        <tbody>
           <?php foreach($func as $item=>$v) {  ?>
                <tr>
                    <td><?php echo $v[0];?></td>
                    <td><i class="ico-{$item[2]}">&nbsp;</i><?php echo $v[1];?></td>
                </tr>
           <?php } ?>
        </tbody>
    </table>
			</div>
		    <div class="btn_group">
		    	
		    	<div class="agree">   <a  href="../install.php">上一步</a></div>
		    	<div class="not_agree agree"><a  href="<?php echo $INSTALL_PATH;?>step2.php">下一步</a</div>
		    </div>
		</div>
	</body>
</html>
