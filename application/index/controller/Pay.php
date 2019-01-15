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
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
class Pay extends Home {

	public function index() {
		if(!is_login()) {
		    $this->redirect("User/login");
		}
		$this->meta_title = '在线充值';
	    $this->assign('meta_title',$this->meta_title);
		return $this->fetch();
	}
	public function lists(){
		 if(!is_login()) {
		    $this->redirect("User/login");
		}			
		$uid=is_login();	
		$map['uid']=$uid;//用户id
		$map['model']="account";//用户id
		$res=getLists("pay",$map,10,"id desc","");
		$this->assign('res', $res);
		$this->meta_title = '充值记录';
		$this->assign('meta_title',$this->meta_title);
		return $this->fetch();
	}   
	public function deal(){
		if(!is_login()) {
		    $this->redirect("User/login");
		}			
	     $Pay=new \app\common\model\Pay;
		 $res=$Pay->deal() ;
         $url=url('pay/over?id='.$res);  
	     if($res){
             $this->success( "支付成功",$url);
		 } else{
			 $this->error($Pay->getError());
		 }
	}  


	public function over($id) {
		   if(!is_login()) {
		      $this->redirect("User/login");
		   }	 
            $uid=is_login();
			$map['uid']=$uid;//用户id
			$map['id']=safe_replace($id);//用户id
            $info=db('pay')->where($map)->find();
			$this->assign('info', $info);
           
		     return $this->fetch();
	  }
      public function  failure() {	
		  
		  return $this->fetch();

	  }	
}
