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
 * 后台提成记录控制器
 */
class Profit extends Home{
     /* 提成记录查询首页 */
	public function index(){     
       if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$map[]  = [$key,'like', '%'.$value.'%'];
				 }
			}
        }
		$map=isset($map)?$map:'';
        $res=getLists('Profit',$map,10,'id desc',"");
	    $this->assign('res', $res);
		$this->meta_title="提成记录管理";
		$this->assign('meta_title', $this->meta_title);
	    return $this->fetch("profit/index"); 
	}


    /* 编辑提成记录 */
	public function edit($id){   
	    if($_REQUEST){
		   $Profit = new \app\admin\model\Profit;
           $res=$Profit->allowField(true)->validate(true)->save($_REQUEST,['id' => $_REQUEST['id']]);
	       if($res){
			   addUserLog("edit_profit",session_uid());
		      $this->success("更新成功！",cookie("__forward__"));
		   }else{
			  $error=$Profit->getError()?$Profit->getError():"更新失败！";
			  $this->error($error);
		   } 
	   }
	   else{
		 $map['id']=$id;
		 $info=db("Profit")->where($map)->find();
	     $this->assign('info', $info);
		
		   cookie("__forward__",input('server.HTTP_REFERER'));
		 $this->meta_title="编辑提成记录";
		 $this->assign('meta_title', $this->meta_title);
	     return $this->fetch("profit/edit");
	   }
	}
	 /* 增加提成记录 */
	public function add($id=""){  
	   if($_REQUEST){
		  $Profit = new \app\admin\model\Profit;
            // 过滤post数组中的非数据表字段数据
          $res=$Profit->validate(true)->allowField(true)->save($_REQUEST);
	      if($res){
			  addUserLog("add_profit",session_uid());
		      $this->success("新增成功！",cookie("__forward__"));
		  }else{
			  $error=$Profit->getError()?$Profit->getError():"新增失败！";
			  $this->error($error);
		  } 
	 }
	  else{
		
		  $this->meta_title="新增提成记录";
		    cookie("__forward__",input('server.HTTP_REFERER'));
		  $this->assign('meta_title', $this->meta_title);
	      return $this->fetch("profit/edit");
	  }
	}
	 /* 删除提成记录*/
	public function del(){   
	    $id=input("id");
	    $map[]=['id',"in",$id];
		if(!$map){
			 $this->error("未选择数据！");
		}
		$model= request()->controller();
		$res=db($model)->where($map)->delete();
		
		if($res){
		   addUserLog("del_profit",session_uid());
		   $this->success("删除成功！");
		}else{
	           $this->error("删除失败！");
		}
	}
	
}
