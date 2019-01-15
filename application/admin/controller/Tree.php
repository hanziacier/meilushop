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
 * 后台分销树控制器
 */
class Tree extends Home{
     /* 分销树查询首页 */
	public function index(){     
        $tree=db("UcenterMember")->select();
	    $this->assign('tree', getSort($tree));
		$this->meta_title="分销树管理";
		$this->assign('meta_title', $this->meta_title);
	    return $this->fetch("tree/index"); 
	}
	 public function lists($id=""){
		 $arr=getMemberList($id);
		 if($arr){
				array_push($arr,$id);
			   $condition["id"]=array("in",$arr);
		}
	    else{
	        $condition["id"]=$id;
	    }
		$field="id,number,pid,username";
		
		/* 查询条件初始化 */
		$list=M("UcenterMember")->where($condition)->field($field)->order("id asc")->select();
        foreach ($list as $k=>$v) {
			                 $i=$v['id'];
							 if($v['id']==$id){
							      $v["pid"]=0;
							 }
							 $arr2[$i]["id"]=$v['id'];
							 $arr2[$i]["pid"]=$v['pid'];
							 $arr2[$i]["number"]=$v['number'];
							 $arr2[$i]["username"]=$v['username']; 
							 
				}
	    $this->assign('list', getSort($arr2));
		$this->assign('id', $id);
        $this->meta_title = '全局隶属关系图';
        $this->display();
    }
  
 public function detail($id=""){
        if($id){
           
			$arr=getChild($id);
			 if($arr){
				array_push($arr,$id);
				$condition["id"]=array("in",$arr);
		   }
		 }
		 $field="id,number,pid,username";
		/* 查询条件初始化 */
		$list=M("UcenterMember")->where($condition)->field($field)->order("id asc")->select();
		$arr=array();
		foreach ($list as $k=>$v) {
			                 $i=$v['id'];
							 if($v['id']==$id){
							      $v["pid"]=0;	 
							 }
							  $arr[$i]["id"]=$v['id'];
							  $arr[$i]["pid"]=$v['pid'];
							 
							  $arr[$i]["username"]=$v['username'];

				}
	    $this->assign('list', getSort($arr));
		$this->assign('id', $id);
        $this->meta_title = '全局隶属关系图';
        $this->display();
    }
  

    /* 编辑分销树 */
	public function edit($id){   
	    if($_REQUEST){
		   $Tree = new \app\admin\model\Tree;
           $res=$Tree->allowField(true)->validate(true)->save($_REQUEST,['id' => $_REQUEST['id']]);
	       if($res){
			   addUserLog("edit_tree",session_uid());
		      $this->success("更新成功！",cookie("__forward__"));
		   }else{
			  $error=$Tree->getError()?$Tree->getError():"更新失败！";
			  $this->error($error);
		   } 
	   }
	   else{
		 $map['id']=$id;
		 $info=db("Tree")->where($map)->find();
	     $this->assign('info', $info);
		
		   cookie("__forward__",input('server.HTTP_REFERER'));
		 $this->meta_title="编辑分销树";
		 $this->assign('meta_title', $this->meta_title);
	     return $this->fetch("tree/edit");
	   }
	}
	 /* 增加分销树 */
	public function add($id=""){  
	   if($_REQUEST){
		  $Tree = new \app\admin\model\Tree;
            // 过滤post数组中的非数据表字段数据
          $res=$Tree->validate(true)->allowField(true)->save($_REQUEST);
	      if($res){
			  addUserLog("add_tree",session_uid());
		      $this->success("新增成功！",cookie("__forward__"));
		  }else{
			  $error=$Tree->getError()?$Tree->getError():"新增失败！";
			  $this->error($error);
		  } 
	 }
	  else{
		
		  $this->meta_title="新增分销树";
		    cookie("__forward__",input('server.HTTP_REFERER'));
		  $this->assign('meta_title', $this->meta_title);
	      return $this->fetch("tree/edit");
	  }
	}
	 /* 删除分销树*/
	public function del(){   
	    $id=input("id");
	    $map['id']=["in",$id];
		if(!$map["id"]){
			 $this->error("未选择数据！");
		}
		$model= request()->controller();
		$res=db($model)->where($map)->delete();
		
		if($res){
		   addUserLog("del_tree",session_uid());
		   $this->success("删除成功！");
		}else{
	           $this->error("删除失败！");
		}
	}
	
}
