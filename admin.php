<?php
// +----------------------------------------------------------------------
// | yershop网店管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
// | 版权申明：yershop网店管理系统不是一个自由软件，是贝云网络官方推出的商业源码，严禁在未经许可的情况下
// | 拷贝、复制、传播、使用yershop网店管理系统的任意代码，如有违反，请立即删除，否则您将面临承担相应
// | 法律责任的风险。如果需要取得官方授权，请联系官方http://www.yershop.com
// +----------------------------------------------------------------------
// [ 应用入口文件 ]
namespace think;
//error_reporting(0);
// [ 应用入口文件 ]
if(version_compare(PHP_VERSION,'5.4.0','<'))  die('require PHP > 5.4.0 !');
$INSTALL_PATH = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']));
if($INSTALL_PATH==="/"){
    $INSTALL_PATH="/";		
}else{
    $INSTALL_PATH= '/'. trim($INSTALL_PATH,'/').'/';
}

define('INSTALL_PATH',$INSTALL_PATH);//安装目录
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
if(!is_file('./data/install.lock')){
	header('Location: '.$INSTALL_PATH.'install.php');
	exit;
}

// 加载框架引导文件
// 加载框架基础引导文件
require __DIR__ . '/thinkphp/base.php';

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应（绑定当前访问到index模块）
Container::get('app')->bind('admin')->run()->send();
