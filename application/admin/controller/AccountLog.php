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
 * 后台资金管理控制器
 */
class AccountLog extends Home{
     /* 资金管理查询首页 */
	public function index(){     
          if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$map[]  = [$key,'like', '%'.$value.'%'];
				 }
			}
        }
		$map=isset($map)?$map:'';	
        $res=getLists('AccountLog',$map,10,'id desc',"");
	    $this->assign('res', $res);
		$this->meta_title="资金管理管理";
		$this->assign('meta_title', $this->meta_title);
	    return $this->fetch("accountlog/index"); 
	}

    /* 编辑资金管理 */
	public function edit($id){   
	    if($_POST){
		   $AccountLog = new \app\admin\model\AccountLog;
           $res=$AccountLog->allowField(true)->validate(true)->save($_POST,['id' => $_POST['id']]);
	       if($res){
			   addUserLog("edit_AccountLog",session_uid());
		      $this->success("更新成功！",cookie("__forward__"));
		   }else{
			  $error=$AccountLog->getError()?$AccountLog->getError():"更新失败！";
			  $this->error($error);
		   } 
	   }
	   else{
		 $map['id']=$id;
		 $info=db("AccountLog")->where($map)->find();
	     $this->assign('info', $info);
		
		 cookie("__forward__",input('server.HTTP_REFERER'));
		 $this->meta_title="编辑资金管理";
		 $this->assign('meta_title', $this->meta_title);
	     return $this->fetch("accountlog/edit");
	   }
	}
	 /* 增加资金管理 */
	public function add($id=""){  
	   if($_POST){
		  $AccountLog = new \app\admin\model\AccountLog;
            // 过滤post数组中的非数据表字段数据
          $res=$AccountLog->validate(true)->allowField(true)->save($_POST);
	      if($res){
			  addUserLog("add_AccountLog",session_uid());
		      $this->success("新增成功！",cookie("__forward__"));
		  }else{
			  $error=$AccountLog->getError()?$AccountLog->getError():"新增失败！";
			  $this->error($error);
		  } 
	 }
	  else{
		
		  $this->meta_title="新增资金管理";
		  cookie("__forward__",input('server.HTTP_REFERER'));
		  $this->assign('meta_title', $this->meta_title);
	      return $this->fetch("accountlog/edit");
	  }
	}
	 /* 删除资金管理*/
	public function del(){   
	    $id=input("id");
	    $map[]=['id',"in",$id];
		if(!$map){
			 $this->error("未选择数据！");
		}
		$res=db("AccountLog")->where($map)->delete();
		if($res){
		   addUserLog("del_AccountLog",session_uid());
		   $this->success("删除成功！");
		}else{
			 $this->error("删除失败！");
		}
	}
	
}
