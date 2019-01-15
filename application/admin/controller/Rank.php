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
class Rank extends Admin{
    /**
     * 订单管理首页
     */
    public function index(){
		if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$map[]  = [$key,'like', '%'.$value.'%'];
				 }
			}
        }
		$map=isset($map)?$map:'';
        $res= getLists('Rank',$map,10,'id desc');
        $this->assign( 'res', $res);
        $this->meta_title = '订单管理';
		$this->assign('meta_title', $this->meta_title);
        return $this->fetch(); 
    }
      /**
     * 订单编辑
     */
	public function edit($id){   
	    if($_POST){
		   $user =new \app\admin\model\Rank;
           $res=$user->save($_POST,['id' => $_POST['id']]);
	       if($res){
		      $this->success("更新成功！");
		   }else{
			   $this->success("更新失败！");
		   } 
	  }
	  else{
		 $map['id']=$id;
		 $info=Db::name("Rank")->where($map)->find();
	     $this->assign('info', $info);
		
		 $this->meta_title="编辑订单";
		 $this->assign('meta_title', $this->meta_title);
	     return $this->fetch();
	   }
	} 
	
	/**
     * 新增订单
     */
	  public function add($id=""){  
	  if($_POST){
		   $user =new \app\admin\model\Rank;
        // 过滤post数组中的非数据表字段数据
       $res=$user->allowField(true)->save($_POST);
	   if($res){
		   $this->success("新增成功！");
		}else{
			 $this->success("新增失败！");
		} 
	}
	  else{
		 
		  $this->meta_title="新增订单";
		  $this->assign('meta_title', $this->meta_title);
	      return $this->fetch("Rank/edit");
	  }
	}
	public function out(){    
        $xlsName  = "Rank";      
		$xlsCell  = array(
            array('id','编号'),
			array('title','订单编号'),
            array('total_money','价格'),
            array('saleslist','订单内容'),
            array('username','联系人'),
            array('mobile','联系方式'), 
			array('total','供应商'),
			array('address','地址'), 
			array('status','订单状态'),
			array('express','快递名称'), 
			array('express_code','快递单号'),
			array('isdao','是否到货'), 
			array('arrive_time','到货时间'), 
			array('uid','用户uid')
        );
        $xlsModel = Db::name($xlsName);
        $xlsData  = $xlsModel->select();      
		 if(!$xlsData){               
                    $this->error('无数据');
                }
		exportExcel($xlsName,$xlsCell,$xlsData); 
	}
	/**
     * 删除订单
     */
	 public function del(){   
	    $id=input("id");
	    $map[]=['id',"in",$id];
		if(!$map){
			 $this->error("未选择数据！");
		}
		$res=Db::name("Rank")->where($map)->delete();
		if($res){
		   $this->success("删除成功！");
		}else{
			 $this->success("删除失败！");
		}
	}

}
