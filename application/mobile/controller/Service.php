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
class Service extends Home{
	
	public function index(){
		if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		
		$uid=is_login();
		$this->meta_title = '我的消息';
        $map['uid']=$uid;//用户id
		$p= input('p')?input('p'):1;
	    $res=  apiLists('Service',$map,"10",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		 if($data){
				foreach($data as &$vo){
					$url=url('del?id='.$vo['id']);
					 $vo['create_time'] =  date("Y-m-d h:i",$vo['create_time']);//时间
					$title=substr_cn($vo['title']);
				    $vo['html'] = '<li>
				<div class="sc_con01_close"><a href="'.$url.'"></a></div>
				<h1>'.$vo['type'].'：</h1>
				<h2>'.$vo['create_time'].'</h2>
				<h3>'.$vo['title'].'</h3>
				<h2>'.$vo['content'].'</h2>
			</li>';
				 
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
	public  function add($id="") {
		
	     if($_POST){
		 
			$save=array();
			foreach($_POST as $key=>$val){
				  $save[$key]=safe_replace($val);
				 
			}
		   $Service = new \app\mobile\model\Service;
		   $res=$Service->validate(true)->allowField(true)->save($save);
	       if($res){
			 
		       $this->success("提交成功！");
		   }else{
			  $error=$Service->getError();
			  $this->error($error?$error:"新增失败！");
		    } 
		 }
			return $this->fetch();
		
		
	}
       /* 删除客服服务*/
	public function del(){   
	    $id=(int)input("id");
	    $map['id']=array("in",$id);
		if(!$map["id"]){
			 $this->error("未选择数据！");
		}
		$res=db("Service")->where($map)->delete();
		if($res){
		 
		   $this->success("删除成功！");
		}else{
			 $this->error("删除失败！");
		}
	}
  
}
