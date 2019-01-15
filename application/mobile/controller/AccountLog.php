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
namespace app\mobile\controller;
use think\Controller;
use think\Db;
/*购物车*/
class AccountLog extends Home{
	
	public function index() {
		  $meta_title = '余额管理';
		
	      return $this->fetch();
		
	}
	/*积分消费明细*/
	public function lists(){
		if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		
		$uid=is_login();
		$this->meta_title = '我的积分';
        $map['uid']=$uid;//用户id
		$p= input('p')?input('p'):1; 
	    $res=  apiLists('AccountLog',$map,"20",'id desc',$p);
        $data = $res['list']?$res['list']:"";
	
		if($data){
				foreach($data as &$vo){
                   if($vo['type']){
				      $vo['type'] ="+".$vo['score'];
				   }else{
				    $vo['type'] ="-".$vo['score'];
				   }
				   $vo['create_time'] =  date("Y-m-d h:i",$vo['create_time']);//时间
				}
			}
	    if(!$_POST){/**大家都在买,推荐位**/
		   $this->assign('list',$data);// 赋值数据集
           $this->assign('maxnum',$res['pagenum']);// 赋值数据集
           return $this->fetch( );
        }else{
		 
		  //AJAX刷新数据
           return $data;  
        }
		
	}
}
