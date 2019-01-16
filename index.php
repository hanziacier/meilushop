<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;
//error_reporting(0);
if(version_compare(PHP_VERSION,'5.7.0','<'))  die('require PHP >= 7.0!');
$INSTALL_PATH = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']));
if($INSTALL_PATH==="/"){
    $INSTALL_PATH="/";		
}else{
    $INSTALL_PATH= '/'. trim($INSTALL_PATH,'/').'/';
}
define('INSTALL_PATH',$INSTALL_PATH);//安装目录
define('ROOT_PATH', dirname(realpath(dirname($_SERVER['SCRIPT_FILENAME']))).INSTALL_PATH);
if(!is_file('./data/install.lock')){
	header('Location: '.$INSTALL_PATH.'install.php');
	exit;
}// 加载基础文件
// 加载框架基础引导文件
require __DIR__ . '/thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->run()->send();
