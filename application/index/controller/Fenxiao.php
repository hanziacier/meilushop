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
namespace app\index\controller;
use think\Controller;
use think\Db;
/**
 * 地址模型控制器
 */
class Fenxiao extends Home {

	
	public function index(){
        if ( !session_uid() ) {
				$this->redirect("User/login");
		}		
           if($_REQUEST){
			foreach ($_REQUEST as $key=>$value){
				if($value){
					$value=safe_replace($value);
					$map[$key]  = ['like', '%'.$value.'%'];
				 }
			}
        }
		if (isset($map['start_time']) ) {
			  unset($map['start_time']);
              $map['create_time'] = ['egt',strtotime($_REQUEST['start_time'])];
        }
        if (isset($map['end_time']) ) {
			unset($map['end_time']);
            $map['create_time'] = ['elt',strtotime($_REQUEST['end_time'])];
        }
		if(input('status')){
		   $map['status'] = input('status');
		}else{
		
		  // $map["status"]=array("gt",0);
		}
		
		$uid=is_login();
		$ids=getChilds($uid);
			//查询条件
		if (isset($map) ) {
			$info=$map;
             $this->assign('info',$info);
		}
		if($ids){
		$map["uid"]=["id",$ids];
		$map["order_type"]=['elt',1];
		$p=input("page")?input("page"):1;
		$num=10;$order="id desc";
		$p=safe_replace($p);
        $res["list"]= Db::name("order")->where($map)->limit($num)->page($p)->order($order)->select();
		foreach($res["list"] as $n=> $val){
                $res["list"][$n]['sales']=Db::name("sales")->where('order_sn=\''.$val['order_sn'].'\'')->select();
		}
		$list = Db::name("order")->where($map)->order($order)->paginate($num);
		$res["page"] = $list->render();
		$res["info"] = $map;
	
		
		//分页数据
        $this->assign('res',$res);
		}
		
		$this->meta_title ="个人中心";	
		$this->assign('meta_title',$this->meta_title);
         //统计
		 $starttime=mktime(0,0,0,date('m'),1,date('Y'));
	     $endtime=mktime(23,59,59,date('m'),date('t'),date('Y'));
       if($ids){
		   unset($map);
            $map["uid"]=["id",$ids];	
			
            $map['update_time'] = ['egt',$starttime];
            $map['update_time'] = ['elt',$endtime];

			//-----------------本月订单数------------//
            $user["mouthNum"]=Db::name("order")->where($map)->count();


             $total=0;
        $data = db("order")->where($map)->select();
        foreach ($data as $k=>$val) {
			$price=$val['total_money'];
            $total +=  $price;
        }
		//-----------本月销售额------------------//
        $user["monthtotal"]=sprintf("%01.2f", $total);


			//-------------总订单数--------------------//
             unset($map['update_time']);
             $user["orderTotalNum"]=Db::name("order")->where($map)->count();


          $total=0;
        $data = db("order")->where($map)->select();
        foreach ($data as $k=>$val) {
			$price=$val['total_money'];
            $total +=  $price;
        }//-------------------总销售额------------------------//
        $user["total"]=sprintf("%01.2f", $total);

            $map2['reg_time'] = ['egt',$starttime];
            $map2['reg_time'] = ['elt',$endtime];
			//-----------------本月注册数-----------------------//
            $user["mouthmember"]=Db::name("ucenterMember")->where($map2)->count();
			 //--------------------------下级总数---------------//
             $user["membernum"]=count($ids);
		    

        }

     	//--------------本月佣金-------------------------------//
			 $map3["uid"]=$uid;	
			 $map3["type"]=3;	
			 $map3['create_time'] = ['egt',$starttime];
             $map3['create_time'] = ['elt',$endtime];

        $total=0;
        $data = db("account_log")->where($map3)->select();
        foreach ($data as $k=>$val) {
			$price=$val['money'];
            $total +=  $price;
        }
	
        $user["monthaccount"]=sprintf("%01.2f", $total);
			//--------------总佣金-------------------------------//
         unset($map3['create_time']);
         $total=0;
        $data = db("account_log")->where($map3)->select();
        foreach ($data as $k=>$val) {
			$price=$val['money'];
            $total +=  $price;
        }
         $user["accounts"]=sprintf("%01.2f", $total);
		 $param["linkid"]=$uid;
		 $user["link"]=  root_url().url('index/index',$param);
        
       //\think\Loader::import('qrcode.qrcode');
        //$text = base64_decode($user["link"]);
		 $UcenterMember=db("UcenterMember")->find($uid);
		
          
        $user["url"]= qrcode($user["link"],$UcenterMember["cover_id"],$uid);

		 $this->assign('user',$user);
		return $this->fetch();
    }
	 /* 取消订单 */
	public function order(){
        if ( !session_uid() ) {
				$this->redirect("User/login");
		}		
           if($_REQUEST){
			foreach ($_REQUEST as $key=>$value){
				if($value){
					$value=safe_replace($value);
					$map[$key]  = ['like', '%'.$value.'%'];
				 }
			}
        }
		if (isset($map['start_time']) ) {
			  unset($map['start_time']);
              $map['create_time'] = ['egt',strtotime($_REQUEST['start_time'])];
        }
        if (isset($map['end_time']) ) {
			unset($map['end_time']);
            $map['create_time'] = ['elt',strtotime($_REQUEST['end_time'])];
        }
		if(input('status')){
		   $map['status'] = input('status');
		}else{
		
		  // $map["status"]=array("gt",0);
		}
		
		$uid=is_login();
		$ids=getChilds($uid);
			//查询条件
		if (isset($map) ) {
			$info=$map;
             $this->assign('info',$info);
		}
		if($ids){
		$map["uid"]=["id",$ids];
		$map["order_type"]=['elt',1];
		$p=input("page")?input("page"):1;
		$num=10;$order="id desc";
		$p=safe_replace($p);
        $res["list"]= Db::name("order")->where($map)->limit($num)->page($p)->order($order)->select();
		foreach($res["list"] as $n=> $val){
                $res["list"][$n]['sales']=Db::name("sales")->where('order_sn=\''.$val['order_sn'].'\'')->select();
		}
		$list = Db::name("order")->where($map)->order($order)->paginate($num);
		$res["page"] = $list->render();
		$res["info"] = $map;
	
		
		//分页数据
        $this->assign('res',$res);
		}
		
		$this->meta_title ="个人中心";	
		$this->assign('meta_title',$this->meta_title);
         //统计
		 $starttime=mktime(0,0,0,date('m'),1,date('Y'));
	     $endtime=mktime(23,59,59,date('m'),date('t'),date('Y'));
       if($ids){
		   unset($map);
            $map["uid"]=["id",$ids];	
			
            $map['update_time'] = ['egt',$starttime];
            $map['update_time'] = ['elt',$endtime];

			//-----------------本月订单数------------//
            $user["mouthNum"]=Db::name("order")->where($map)->count();


             $total=0;
        $data = db("order")->where($map)->select();
        foreach ($data as $k=>$val) {
			$price=$val['total_money'];
            $total +=  $price;
        }
		//-----------本月销售额------------------//
        $user["monthtotal"]=sprintf("%01.2f", $total);


			//-------------总订单数--------------------//
             unset($map['update_time']);
             $user["orderTotalNum"]=Db::name("order")->where($map)->count();


          $total=0;
        $data = db("order")->where($map)->select();
        foreach ($data as $k=>$val) {
			$price=$val['total_money'];
            $total +=  $price;
        }//-------------------总销售额------------------------//
        $user["total"]=sprintf("%01.2f", $total);

            $map2['reg_time'] = ['egt',$starttime];
            $map2['reg_time'] = ['elt',$endtime];
			//-----------------本月注册数-----------------------//
            $user["mouthmember"]=Db::name("ucenterMember")->where($map2)->count();
			 //--------------------------下级总数---------------//
             $user["membernum"]=count($ids);
		    

        }

     	//--------------本月佣金-------------------------------//
			 $map3["uid"]=$uid;	
			 $map3["type"]=3;	
			 $map3['create_time'] = ['egt',$starttime];
             $map3['create_time'] = ['elt',$endtime];

        $total=0;
        $data = db("account_log")->where($map3)->select();
        foreach ($data as $k=>$val) {
			$price=$val['money'];
            $total +=  $price;
        }
	
        $user["monthaccount"]=sprintf("%01.2f", $total);
			//--------------总佣金-------------------------------//
         unset($map3['create_time']);
         $total=0;
        $data = db("account_log")->where($map3)->select();
        foreach ($data as $k=>$val) {
			$price=$val['money'];
            $total +=  $price;
        }
         $user["accounts"]=sprintf("%01.2f", $total);
		 $param["linkid"]=$uid;
		 $user["link"]=  root_url().url('index/index',$param);
        
       //\think\Loader::import('qrcode.qrcode');
        //$text = base64_decode($user["link"]);
		 $UcenterMember=db("UcenterMember")->find($uid);
		
          
        $user["url"]= qrcode($user["link"],$UcenterMember["cover_id"],$uid);

		 $this->assign('user',$user);
		return $this->fetch();
    }

public  function plan(){
        
		  if ( !is_login() ) {
					$this->error( "您还没有登陆",url("User/login") );
		   }
		   $uid=is_login();
		 
		 $param["linkid"]=$uid;
		 $user["link"]=  root_url().url('index/index',$param);
        
       //\think\Loader::import('qrcode.qrcode');
        //$text = base64_decode($user["link"]);
		 $UcenterMember=db("UcenterMember")->find($uid);
		
          
        $user["url"]= qrcode($user["link"],$UcenterMember["cover_id"],$uid);
  
         $this->meta_title = '我的推广';
		$this->assign('meta_title',$this->meta_title);
		 $this->assign('user',$user);
		return $this->fetch();

}
public  function member(){
           if ( !is_login() ) {
					$this->error( "您还没有登陆",url("User/login") );
		   }
		
		  $uid=is_login();
		$ids=getChilds($uid);
		
		if($ids){
		    $map["uid"]=["id",$ids];
		}  
		$this->meta_title = '团队成员';
		$this->assign('meta_title',$this->meta_title);
       if(!isset($map)){
	    $map["id"]=["lt",0];
	   
	   }
		$res=getLists("ucenter_member",$map,5,"id desc","");
		$this->assign('res', $res);return $this->fetch();
         
   }
   public  function create(){
           if ( !is_login() ) {
					$this->error( "您还没有登陆",url("User/login") );
		   }
		   $fenxiao=new \app\common\model\Fenxiao;
		   $url=$fenxiao->createurl();
           if($url){
				$this->success("创建成功",$url);
			}
			else{ 
				$this->error("创建失败");
			}
         
   }
     public  function img(){
           if ( !is_login() ) {
					$this->error( "您还没有登陆",url("User/login") );
		   }
		   $fenxiao=new \app\common\model\Fenxiao;
		   $url=$fenxiao->img();
           if($url){
				$this->success("创建成功",$url);
			}
			else{ 
				$this->error("创建失败");
			}
         
   }
   public  function mine($id = null, $pid = 0){
           if ( !is_login() ) {
					$this->error( "您还没有登陆",url("User/login") );
		   }
           $uid=is_login();	
		   $map['uid']=$uid;//用户id
		   $map['type']=$uid;//用户id
		   $res=getLists("account_log",$map,5,"id desc","");
		   $this->assign('res', $res);
            $this->meta_title = '我的佣金';
		    $this->assign('meta_title',$this->meta_title);
           return $this->fetch();
         
   }
   

   
}
