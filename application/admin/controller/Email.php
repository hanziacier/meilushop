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
namespace app\admin\controller;
use think\Controller;
use think\Db;
/**
 * 后台邮件控制器
 */
class Email extends Home{
     /* 邮件查询首页 */
	public function index(){     
         if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$map[]  = [$key,'like', '%'.$value.'%'];
				 }
			}
        }
		$map=isset($map)?$map:'';
        $res=getLists('Email',$map,10,'id desc',"");
	    $this->assign('res', $res);
		$this->meta_title="邮件管理";
		$this->assign('meta_title', $this->meta_title);
	    return $this->fetch("email/index"); 
	}


    /* 编辑邮件 */
	public function edit($id){   
	    if($_POST){
		   $Email = new \app\admin\model\Email;
           $res=$Email->allowField(true)->validate(true)->save($_POST,['id' => $_POST['id']]);
	       if($res){
			   addUserLog("edit_Email",session_uid());
		      $this->success("更新成功！",cookie("__forward__"));
		   }else{
			  $error=$Email->getError()?$Email->getError():"更新失败！";
			  $this->error($error);
		   } 
	   }
	   else{
		 $map['id']=$id;
		 $info=db("Email")->where($map)->find();
	     $this->assign('info', $info);
		
		   cookie("__forward__",input('server.HTTP_REFERER'));
		 $this->meta_title="编辑邮件";
		 $this->assign('meta_title', $this->meta_title);
	     return $this->fetch("email/edit");
	   }
	}
	 /* 增加邮件 */
	public function add($id=""){  
	   if($_POST){
		  $Email = new \app\admin\model\Email;
            // 过滤post数组中的非数据表字段数据
          $res=$Email->validate(true)->allowField(true)->save($_POST);
	      if($res){
			  addUserLog("add_Email",session_uid());
		      $this->success("新增成功！",cookie("__forward__"));
		  }else{
			  $error=$Email->getError()?$Email->getError():"新增失败！";
			  $this->error($error);
		  } 
	 }
	  else{
		
		  $this->meta_title="新增邮件";
		    cookie("__forward__",input('server.HTTP_REFERER'));
		  $this->assign('meta_title', $this->meta_title);
	      return $this->fetch("email/edit");
	  }
	}
	 /* 删除邮件*/
	public function del(){   
	    $id=input("id");
	    $map['id']=array("in",$id);
		if(!$map["id"]){
			 $this->error("未选择数据！");
		}
		$res=db("Email")->where($map)->delete();
		if($res){
		   addUserLog("del_Email",session_uid());
		   $this->success("删除成功！");
		}else{
			 $this->error("删除失败！");
		}
	}
	
}
