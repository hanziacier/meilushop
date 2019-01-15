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
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Admin extends Controller{  

    protected function _initialize(){
	    if( !is_login()){// 还没登录 跳转到登录页面
            $this->redirect('login/index');
        } if ( $_POST ) {
            $this->error('未授权');
        } 
	    $this->uid=is_login();
		$this->assign('INSTALL_PATH', INSTALL_PATH);
		 // 检测访问权限
        $auth=$this->checkAuth();
		$controller=Request::instance()->controller();
		$url=strtolower($controller."/index");
		//echo $url;
        if ( $auth === false ) {
            $this->error('403:禁止访问');
        }else if($auth === false ){
            $auth=$this->checkAuth();//检测分类栏目有关的各项动态权限
            if( $auth === false ){
		          $rule=$url;
				  $res=$this->checkid($rule,array('in','1,2'));
                if(!$res){
                    $this->error('未授权访问');
                }
            }elseif($auth === false ){
                $this->error('未授权访问!');
            }
        }
		$condition["url"]=$url;
		$info=db('Module')->where($condition)->field("url,id,pid,group_id")->find();
		$id=$info["id"];
		$group_id=$info["group_id"];
        $where['id']=$id;
		$now=db('Module')->where($where)->field("id,title,pid")->find();
		$this->assign('now', $now); 
        $map['pid']=0;
		$group_id=$group_id?$group_id:1;
        $map['group_id']=$group_id;
		$group=db('group')->order('sort asc')->select();
		$this->assign('group', $group);
		$arr=array();
        $side=db('Module')->where($map)->order('id asc,sort desc')->field("id,title,pid")->select();
        foreach( $side as $n=> $val ){
				$arr[]=$val['id'];
				$map2["pid"]=$val['id'];  
			    $list=db('Module')->where($map2)->field("id,title,pid")->order('sort desc')->select( );
				foreach( $list as $n=> $val1 ){
				   $arr[]=$val1['id'];
		        }
		}
		unset($map);
		$map['id']=array("in",$arr);
		$map['status']=1;
		//侧栏
        $sidebar=db('Module')->where($map)->order('sort desc')->field("id,title,pid")->select();
		foreach ($sidebar as & $value){
			$value["url"]  = get_moude_url($value['id']);
        }
        $this->assign('sidebar', json_encode($sidebar));
	}

    protected function checkAuth(){
	  
	   $reg_time=config('database.reg_time');
	   $time=session("utime");
	   if($reg_time==$time){
		      return true;
			  //管理员允许访问任何页面
	   }  
	   return null;//不明,需checkRule
    }

    final protected function checkid($rule, $type=AuthRule::RULE_URL, $mode='url'){
        $IS_ROOT= $this->checkAuth();
		if($IS_ROOT){
            return true;//管理员允许访问任何页面
        }
        static $Auth    =   null;
        if (!$Auth) {
            $Auth       =   new \think\Auth();
        }
		$uid=is_login();
        if(!$Auth->check($rule,$uid,$type,$mode)){
            return false;
        }
        return true;
    }
}
