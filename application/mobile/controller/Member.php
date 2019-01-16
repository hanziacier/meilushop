<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\mobile\controller;
use think\Db;
/**
 * 评论模型控制器
 */
class Member extends Home {

    public function index() {
		if ( !is_login() ) {
			 $this->redirect("User/login" );
		}
        $uid=is_login();
		
        $map['uid']=$uid;
		$map["status"]=0;

		$res["num"]=db("order")->where($map)->count();
        unset($map["status"]);
		$map["status"]=1;
		$res["num1"]=db("order")->where($map)->count();
         unset($map["status"]);
		 $map["status"]=2;
		 $res["num2"]=db("order")->where($map)->count();
		
		  unset($map["status"]);
		
		 $res["num3"]=db("collect")->where($map)->count();
		 
		
		 $res["num4"]=db("service")->where($map)->count();
		 $this->assign('res',$res);// 赋值数据集  
		 if(session("log")){
		     $this->assign('log',session("log"));// 赋值数据集
		 }
		return $this->fetch();     
	   
    }
	 public function edit() {
		if ( !is_login() ) {
			 $this->redirect("User/login" );
		}
        $uid=is_login();
		
        $map['id']=$uid;
		$info= db('ucenterMember')->where($map)->order('id desc')->select();
		$this->assign('info',$info);// 赋值数据集  
	
		return $this->fetch();     
	   
    } 
	public  function update() {
        if(!is_login()) {
			$this->error( "您还没有登陆",url("User/login") );
		}		
	    if($_POST){ //提交表单
		  
		   $map["id"]=is_login();
		   $data=array();
		   foreach($_POST as $key=>$val){
		      $data[$key]=safe_replace($val);
		    }
		    $field="mobile,username,birthday,star,sex,cover_id";
		    $res=db("UcenterMember")->where($map)->field($field)->update($data);
            if(false !== $res){
                $this->success('更新成功！');
            } else {
               $error= $UcenterMember->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } 	    
    }
}
