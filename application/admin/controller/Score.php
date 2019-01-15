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
 * 后台积分控制器
 */
class Score extends Home{
     /* 积分查询首页 */
	   public function index(){
		
		$Order=model("order");
		$res=$Order->getList(10,"id desc") ;
		//查询条件
		$info=$res["info"];
        $this->assign('info',$info);
		//dump($info);
		unset($res["info"]);
		//分页数据
        $this->assign('res',$res);
        $this->meta_title = '订单管理';
		$this->assign('meta_title', $this->meta_title);
        return $this->fetch(); 
    }

    /* 编辑积分 */
	public function edit($id){   
	    if($_REQUEST){
		   $Order = new \app\admin\model\Order;
           $res=$Order->allowField(true)->validate(true)->save($_REQUEST,['id' => $_REQUEST['id']]);
	       if($res){
			   addUserLog("edit_score",session_uid());
		      $this->success("更新成功！",cookie("__forward__"));
		   }else{
			  $error=$Order->getError()?$Order->getError():"更新失败！";
			  $this->error($error);
		   } 
	   }
	   else{
		 $map['id']=$id;
		 $info=db("Order")->where($map)->find();
	     $this->assign('info', $info);
		
		 cookie("__forward__",input('server.HTTP_REFERER'));
		 $this->meta_title="编辑积分";
		 $this->assign('meta_title', $this->meta_title);
	     return $this->fetch("score/edit");
	   }
	}
	 /* 增加积分 */
	public function add($id=""){  
	   if($_REQUEST){
		  $Order = new \app\admin\model\Order;
            // 过滤post数组中的非数据表字段数据
          $res=$Order->validate(true)->allowField(true)->save($_REQUEST);
	      if($res){
			  addUserLog("add_score",session_uid());
		      $this->success("新增成功！",cookie("__forward__"));
		  }else{
			  $error=$Order->getError()?$Order->getError():"新增失败！";
			  $this->error($error);
		  } 
	 }
	  else{
		
		  $this->meta_title="新增积分";
		    cookie("__forward__",input('server.HTTP_REFERER'));
		  $this->assign('meta_title', $this->meta_title);
	      return $this->fetch("score/edit");
	  }
	}
	 /* 删除积分*/
	public function del(){   
	    $id=input("id");
	    $map[]=['id',"in",$id];
		if(!$map){
			 $this->error("未选择数据！");
		}
		$model= request()->controller();
		$res=db($model)->where($map)->delete();
		
		if($res){
		   addUserLog("del_score",session_uid());
		   $this->success("删除成功！");
		}else{
	           $this->error("删除失败！");
		}
	} 
	/**
     * 批量发货
     */
	 public function send(){   
	    $map['status']=1;
		$count=db("Order")->where($map)->count();
       if(!$count){
		   $this->error("无待发货订单");
		}
		$where["status"]=0;//未使用快递数量
		$count2=db("express")->where($where)->count();
		if($count>$count2){
		   $this->error("快递单数量不足,缺少".($count-$count2)."张");
		}
		$list=db("express")->where($where)->select();
		$data=db("order")->where($map)->select();
		$res;
		foreach ($list as $key=>$v){ 
			      $ex["id"]=$v["id"] ;
                  $save["express"]=$v["title"] ;
				  $save["express_code"]=$v["code"] ;
				  foreach ($data as $k=>$val){
                      $condition["id"]=$val["id"]; 
					  $save["send_time"]=time() ;//发货时间 
					  $save["status"]=2 ;//发货
					  db("order")->where($condition)->update($save);
			       } 
				$update["update_time"]=time() ;//使用时间 
			    $update["status"]=1 ;//设置为已使用
				db("express")->where($ex)->update($update);
         $res=+$key;
		}
		if($res){
		   $this->success("删除成功！");
		}else{
			 $this->error("删除失败！");
		}
	}
	/**
     * 批量确认订单
     */
	 public function confirm(){   
	    $map['status']=2;
		$data=db("order")->where($map)->select();
		if(!$data){
		   $this->error("无待确认订单");
		}
		$res;
	    foreach ($data as $k=>$val){
                      $condition["id"]=$val["id"];  
					  $save["confirm_time"]=time() ;//确认时间 
					  $save["status"]=3 ;//发货
					  if((time()-$v["send_time"])/(60*60*24)>=15){
					     db("order")->where($condition)->update($save);  
					  }  
		 $res=+$k;
		} 
		if($res){
		   $this->success("操作成功！");
		}else{
			 $this->error("操作失败！");
		}
	}
	
	/**
     * 订单详情
     */
	public function detail($id){   
	   
		 $map['id']=$id;
		 $info=db("Order")->where($map)->find();
	     $this->assign('info', $info);
		 $list=db("sales")->where('order_sn=\''.$info['order_sn'].'\'')->select();
	     $this->assign('list', $list);
		 $this->meta_title="订单详情";
		 $this->assign('meta_title', $this->meta_title);
	     return $this->fetch();
	   
	}
	
}
