<?php
// +----------------------------------------------------------------------
// | yershop网店管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
// | 版权申明：yershop网店管理系统不是一个自由软件，是贝云网络官方推出的商业源码，严禁在未经许可的情况下
// | 拷贝、复制、传播、使用yershop网店管理系统的任意代码，如有违反，请立即删除，否则您将面临承担相应
// | 法律责任的风险。如果需要取得官方授权，请联系官方http://www.yershop.com
// +----------------------------------------------------------------------
namespace app\mobile\controller;
use think\Controller;
use think\Db;
/**
 * 后台红包控制器
 */
class Bonus extends Home{
     /* 红包查询首页 */
		public function index(){
		if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		
		$uid=is_login();
		$this->meta_title = '我的收藏';
        $map['uid']=$uid;//用户id
		$p= input('p')?input('p'):1;
	    $res=  apiLists('Bonus',$map,"10",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				  
				 
				   $vo['create_time'] =  date("Y-m-d",$vo['create_time']);//时间
				   $vo['end_time'] =  date("Y-m-d",$vo['end_time']);//时间
				 
				    $vo['html'] = '<li>
		<div class="sh_con04_t">
		<div class="sh_con04_tl"><img src="'.INSTALL_PATH.'public/mobile/images/hb.jpg"/><h1><span>￥</span>'.$vo['money'].'</h1><h2>会员红包</h2></div>
		<div class="sh_con04_tr"><a href="#">进店使用</a></div>
		<div class="sh_con04_tm">
		<h1>'.$vo['title'].'</h1>
		<h2>· 满'.$vo['total'].'元可用 <br/>· '.$vo['create_time'].' - '.$vo['end_time'].' <br/>· '.$vo['intro'].'</h2>
		</div>
		</div>
		</li>
';
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


    /* 编辑红包 */
	public function edit($id){   
	    if($_POST){
		   $Bonus = new \app\admin\model\Bonus;
           $res=$Bonus->allowField(true)->validate(true)->save($_POST,['id' => $_POST['id']]);
	       if($res){
			   addUserLog("edit_Bonus",session_uid());
		      $this->success("更新成功！",cookie("__forward__"));
		   }else{
			  $error=$Bonus->getError()?$Bonus->getError():"更新失败！";
			  $this->error($error);
		   } 
	   }
	   else{
		 $map['id']=$id;
		 $info=db("Bonus")->where($map)->find();
	     $this->assign('info', $info);
		 cookie("__forward__",input('server.HTTP_REFERER'));
		 $this->meta_title="编辑红包";
		 $this->assign('meta_title', $this->meta_title);
	     return $this->fetch("bonus/edit");
	   }
	}
	 /* 增加红包 */
	public function add($id=""){  
	   if($_POST){
		  $Bonus = new \app\admin\model\Bonus;
            // 过滤post数组中的非数据表字段数据
          $res=$Bonus->validate(true)->allowField(true)->save($_POST);
	      if($res){
			  addUserLog("add_Bonus",session_uid());
		      $this->success("新增成功！",cookie("__forward__"));
		  }else{
			  $error=$Bonus->getError()?$Bonus->getError():"新增失败！";
			  $this->error($error);
		  } 
	 }
	  else{
		
		  $this->meta_title="新增红包";
		    cookie("__forward__",input('server.HTTP_REFERER'));
		  $this->assign('meta_title', $this->meta_title);
	      return $this->fetch("bonus/edit");
	  }
	}
	 /* 删除红包*/
	public function del(){   
	    $id=input("id");
	    $map['id']=array("in",$id);
		if(!$map["id"]){
			 $this->error("未选择数据！");
		}
		$res=db("Bonus")->where($map)->delete();
		if($res){
		   addUserLog("del_Bonus",session_uid());
		   $this->success("删除成功！");
		}else{
			 $this->error("删除失败！");
		}
	}
	
}
