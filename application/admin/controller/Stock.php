<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liuwei <1010422715@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Stock extends Admin{
    public function index(){     
        if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$map[]  = [$key,'like', '%'.$value.'%'];
				 }
			}
        }
		$map=isset($map)?$map:'';
		$res=getLists('Stock',$map,10,'id desc',"");;
	    $this->assign('res', $res);
		$this->meta_title="库存管理";
		$this->assign('meta_title', $this->meta_title);
	    return $this->fetch(); 
	}

   public function edit($id){   
	    if($_POST){
		   $Stock = model('Stock');
           $res=$Stock->save($_POST,['id' => $_POST['id']]);
	       if($res){
		      $this->success("更新成功！");
		   }else{
			   $this->success("更新失败！");
		   } 
	  }
	  else{
		     $map['id']=$id;
            /* 获取数据 */
             $info=Db::name('Stock')->where($map)->find($id);       
            
			 $this->assign('info', $info);
		     $this->meta_title="编辑库存-".$info["title"];
		     $this->assign('meta_title', $this->meta_title);
	         return $this->fetch();
	   }
	}
    public function add($id=""){  
	    if($_POST){
		   $Stock = model('Stock');
           // 过滤post数组中的非数据表字段数据
           $res=$Stock->allowField(true)->save($_POST);
	     if($res){
		      $this->success("新增成功！");
		  }else{
			  $this->success("新增失败！");
		  } 
	   }
	  else{
		    $typelist =Db::name('types')->select();
		    $this->assign('typelist',$typelist);
		    $map['pid']  = 0;
			$list=Db::name('Stock')->where($map)->select();
		    $this->assign('list',$list);
	        return $this->fetch("Stock/edit");
	  }
	}
	 public function del(){   
	    $id=input("id");
	    $map['id']=array("in",$id);
		if(!$map["id"]){
			 $this->error("未选择数据！");
		}
		$res=Db::name("Stock")->where($map)->delete();
		if($res){
		   $this->success("删除成功！");
		}else{
			 $this->success("删除失败！");
		}
	}



}