<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Model extends Admin{
    public function index(){     
        if(isset($_GET['title'])){
            $map['title']  = array('like', '%'.(string)input('title').'%');
        }else{
			$map="";
		}
        $res=getLists('model',$map,10,'id desc',"");;
	    $this->assign('res', $res);
		$this->meta_title="模型管理";
		$this->assign('meta_title', $this->meta_title);
	    return $this->fetch(); 
	}
	


	public function edit($id){   
	    if($_POST){
		   $model = new \app\modelmin\model\model;
           $res=$model->validate(true)->allowField(true)->save($_POST,['id' => $_POST['id']]);
	       if($res){
			  modeldUserLog("edit_model",session_uid());
		      $this->success("更新成功！");
		   }else{
			    $error=$model->getError()?$model->getError():"更新失败！";
			    $this->error($error);
		   } 
	  }
	  else{
		 $map['id']=$id;
		 $info=Db::name("model")->where($map)->find();
	     $this->assign('info', $info);
		 unset($map);
		 $map['pid']=0;
	     $list =Db::name('category')->where($map)->select(); 
            /* 获取模块信息 */
         $this->assign('list', $list);
		 $this->meta_title="编辑模型-".$info["title"];
		 $this->assign('meta_title', $this->meta_title);
	     return $this->fetch();
	   }
	}
	  public function add($id=""){  
	  if($_POST){
		  $model =new \app\admin\model\model;
            // 过滤post数组中的非数据表字段数据
          $res=$model->validate(true)->allowField(true)->save($_POST);
	      if($res){
			   modeldUserLog("modeld_model",session_uid());
		      $this->success("新增成功！");
		  }else{
			  $error=$model->getError()?$model->getError():"新增失败！";
			  $this->error($error);
		  } 
	}
	  else{
		  $map['pid']=0;
	      $list =Db::name('category')->where($map)->select(); 
	      $this->assign('list', $list);
		  $this->meta_title="新增模型";
		  $this->assign('meta_title', $this->meta_title);
	      return $this->fetch("model/edit");
	  }
	}
	 public function del(){   
	    $id=input("id");
	    $map['id']=array("in",$id);
		if(!$map["id"]){
			 $this->error("未选择数据！");
		}
		$res=Db::name("model")->where($map)->delete();
		if($res){
		   modeldUserLog("del_model",session_uid());
		   $this->success("删除成功！");
		}else{
			 $this->error("删除失败！");
		}
	}
	
}
