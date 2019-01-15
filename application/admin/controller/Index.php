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
use think\Db;
class Index extends Home{ 
  public function index() {    

	 	       $this->meta_title="首页";
		   $this->assign('meta_title', $this->meta_title);
		   $info["category"]=Db::name('Document')->field("id")->count();      
		   $info["user"]=Db::name('ucenterMember')->field("id")->count();  
		   $info["log"]=Db::name('userLog')->field("id")->count();
		    $map[]=["model",'=',"visitor"];
           $info["visitor"]=Db::name('count')->where($map)->field("id")->count();	
		   $info["ad"]=Db::name('ad')->field("id")->count();
		   $info["group"]=Db::name('group')->field("id")->count();
		   $info["picture"]=Db::name('ad')->field("id")->count();
		   $info["comment"]=Db::name('group')->field("id")->count();
		   $this->assign('info', $info);
		   //访客数
		    unset($map);$where = [
["model",'=',"visitor"],
['create_time', ['lt', time()], ['gt', strtotime('-29 days')], 'and']
];
		  
		  $list["visitor_list"]=Db::name('count')->where($where)->select();
		
		   unset($map);
		   //注册会员数
		   $map[]=["model",'=',"member"];
		   $list["member_list"]=Db::name('count')->where($map)->select();
		   
		    
		   $date[0] = date('Y-m-d', strtotime('-6 days'));
		   $date[1] = date('Y-m-d', strtotime('-5 days'));
		   $date[2] = date('Y-m-d', strtotime('-4 days'));
		   $date[3] = date('Y-m-d', strtotime('-3 days'));
		   $date[4] = date('Y-m-d', strtotime('-2 days'));
		   $date[5] = date('Y-m-d', strtotime('-1 days'));
		   $date[6] = date('Y-m-d', time());
		   $this->assign('date', $date);
		   $this->assign('list', $list);
	     
			return $this->fetch();	
	     
			return $this->fetch();	
		  
		
	}
    public function admin()
    {      
	    return $this->fetch(); 
	}
	  public function login()
    {      
	      
	       return $this->fetch();
	}
}
