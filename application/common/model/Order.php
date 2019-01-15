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
namespace app\common\model;
use think\Model;
use think\Db;
/**
 * 文档基础模型
 */
class Order extends Model{

  
    public function getPageList($num,$order){
       
	     if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$value=safe_replace($value);
					$map[]  = [$key,'like', '%'.$value.'%'];
				 }
			}
        }
		if (isset($map['start_time']) ) {
			  unset($map['start_time']);
              $map[]=['create_time','egt',strtotime($_POST['start_time'])];
        }
        if (isset($map['end_time']) ) {
			unset($map['end_time']);
            $map[]=['create_time','elt',strtotime($_POST['end_time'])];
        }
		if(input('status')){
		   $map[]=['status','=',input('status')];
		}else{
		
		  // $map["status"]=array("gt",0);
		}
		$map[]=["uid",'=',is_login()];
		$map[]=["order_type",'neq',1];
		$p=input("page")?input("page"):1;
		$p=safe_replace($p);
        $res["list"]= Db::name("order")->where($map)->limit($num)->page($p)->order($order)->select();
		foreach($res["list"] as $n=> $val){
                $res["list"][$n]['sales']=Db::name("sales")->where('order_sn=\''.$val['order_sn'].'\'')->select();
		}
		$list = Db::name("order")->where($map)->order($order)->paginate($num);
		$res["page"] = $list->render();
		$res["info"] = $map;
		return $res;
    }

    public function add(){
       
	    $uid=session_uid(); 
		$id=input('post.id');
	   	$ids=explode(",",$id);
        $map[]=["uid",'=',$uid];	
        $map[]=["sku_id","in",$ids];		
		$cart =Db::name("cart")->where($map)->select();
		if(!$cart){
			$this->error= "选择错误";return false;
		}
		$sum = 0;$price = 0.00;
		$sn=$this->ordersn();
		$sales=Db::name("sales");$saleslist="";$ship_price=0.00;
		 foreach ($cart as $key=>$val) { 
			    $sum += $val['num'];
				$sid=$val["sku_id"];
			    $val["sku_id"]=$sid;
                unset($val['id']);			 
				unset($val['path']);
				unset($val['key']);
				$xji=$val['num']*$val['price'];
				$price += $xji;
				$ship_price+=get_goods($val['goods_id'],"spress");
				$val["title"]=get_goods($val['goods_id'],"title");
				$val["total"]=$xji;
				$val["order_sn"]=$sn;
				Db::name("sales")->insert($val);
			    $saleslist .="{$val["title"]} {$val['specifications']} 数量{$val['num']} 单价{$val['price']} 小计$xji</br>";//标识号
                $key='cart.'.$sid;
				session($key,null);
				$data["id"]= $sid;
				Db::name("cart")->where($data)->delete();
                
				
		   }  
		 $data["ship_price"]=$ship_price;
		 $data["num"]=$sum;
		 $data["total"]=$price;
		 $data["total_money"]=$price+$ship_price;
		 $data["saleslist"]=$saleslist;
         $data["uid"]=$uid;	
         $data['status']=-1;
		 $data["order_sn"]=$sn;
		 $data["order_type"]=0;//普通订单
		 $data["create_time"]=time();
		 $res=Db::name("order")->insertGetId($data);
		 return $res;
    }
	//立即购买
	 public function buy() {
		
		$uid=session_uid(); 
		$num=safe_replace(input('num'));
		if(!($num && is_numeric($num))){
		   $this->error='分类ID错误！';return;
		}
		$goodsid=input('post.goodsid'); // 用intval过滤$_POST['id']
        $path=input('post.path');
		if($path){
		    $map['path']=safe_replace($path);
		}
		if($goodsid){
		    $map['goods_id']=safe_replace($goodsid);
		}
		$info=Db::name("sku")->where($map)->find();
        if(!$info){
		   $this->error='sku不存在！';return ;
		}
		if(!$info['num']){
		   $this->error='sku库存数量为0！';return;
		}
		$sum = 0;$price = 0.00;
		$sn=$this->ordersn();
	    $val["sku_id"]=$info["id"];
		$total=$num*$info['price'];
		$val["title"]=get_goods($info['goods_id'],"title");
		$val["total"]=$total;
		$val["price"]=$info['price'];
        $val["num"]=$num;
		$val["order_sn"]=$sn;
		$val["goods_id"]=$goodsid;
		$val["uid"]=$uid;
		Db::name("sales")->insert($val);
		 $arr=explode(',',$info['path']);$specifications="";
						   foreach($arr as $v){
						     $specifications.="&nbsp;".get_specs_title($v) ;
						   }
		 $saleslist =$val["title"] .$specifications ."数量".$val['num']."单价".$val['price']." 小计".$total."</br>";//标识号 
		 $ship_price=get_goods($info['goods_id'],"spress");
		 $data["total"]=$total;
         $data["num"]=$num;
		 $data["ship_price"]=$ship_price;
		 $data["total_money"]=$total+$ship_price;
		 $data["saleslist"]=$saleslist;
         $data["uid"]=$uid;	
         $data['status']=-1;
		 $data["order_type"]=0;//普通订单
		 $data["order_sn"]=$sn;
		 $data["create_time"]=time();
		 $res=Db::name("order")->insertGetId($data);
		return $res;

    }
	//立即购买
	 public function pin() {
		
		$uid=session_uid(); 
		$num=safe_replace(input('num'));
		if(!($num && is_numeric($num))){
		   $this->error='分类ID错误！';return;
		}
		$goodsid=input('post.goodsid'); // 用intval过滤$_POST['id']
        $path=input('post.path');
		if($path){
		    $map['path']=safe_replace($path);
		}
		if($goodsid){
		    $map['goods_id']=safe_replace($goodsid);
		}
		
        $where2['id']=(int)safe_replace($goodsid);
        $info=Db::name("goods")->where($where2)->find();
        if(!$info){
		   $this->error='商品不存在！';return ;
		}
		if(!$info['num']){
		   $this->error='sku库存数量为0！';return;
		}
		$max=$info["pin_max_num"];
        $where['goods_id']=(int)safe_replace($goodsid);
		$where['status']=1;
        $order_num=Db::name("order")->where($where)->count();
        if($order_num>=$max){
	       $this->error='拼团已达人数！';return ;
	     }
		$sum = 0;
		$price = $info['pin_price'];
		$sn=$this->ordersn();
	    $val["sku_id"]=$info["id"];
		$total=$num*$price;
		$val["title"]=$info['title'];
		$val["total"]=$total;
		$val["price"]=$info["pin_price"];
        $val["num"]=$num;
		$val["order_sn"]=$sn;
		$val["goods_id"]=$goodsid;
		$val["uid"]=$uid;
		Db::name("sales")->insert($val);
		 $specifications="";
		 if($path){
		 $arr=explode(',',$path);
						   foreach($arr as $v){
						     $specifications.="&nbsp;".get_specs_title($v) ;
						   }
			}
		 $saleslist =$val["title"] .$specifications ."数量".$val['num']."单价".$val['price']." 小计".$total."</br>";//标识号 
		 //$ship_price=$info["spress"];
		 $data["total"]=$total;
         $data["num"]=$num;
		 $data["ship_price"]=0;
		 $data["total_money"]=$total;
		 $data["saleslist"]=$saleslist;
         $data["uid"]=$uid;	
		 $data["goods_id"]=$goodsid;
         $data['status']=-1;
		 $data["pin_status"]=1;
		 $data["order_type"]=2;//拼团订单
		 $data["order_sn"]=$sn;
		 $data["create_time"]=time();
		 $res=Db::name("order")->insertGetId($data);
		return $res;

    }

	//积分兑换
	 public function score() {
		
		$uid=session_uid(); 
		$num=safe_replace(input('num'));
		if(!($num && is_numeric($num))){
		   $this->error='分类ID错误！';return;
		}
		$goodsid=input('post.goodsid'); // 用intval过滤$_POST['id']
        $path=input('post.path');
		if($path){
		    $map['path']=safe_replace($path);
		}
		if($goodsid){
		    $map['goods_id']=safe_replace($goodsid);
		}
		$info=Db::name("sku")->where($map)->find();
        if(!$info){
		   $this->error='sku不存在！';return ;
		}
		if(!$info['num']){
		   $this->error='sku库存数量为0！';return;
		}

		$total_fee=get_goods($info['goods_id'],"score");;
		$total=$num*$total_fee;
        $where["id"]=$uid;
		$ucenter=Db::name("ucenterMember")->where($where)->find(); 
		$account=$ucenter["score"];
			
		 //积分支付
		if($account<$total){
		    $this->error='积分不足！';return;
		}
		$sum = 0;$price = 0.00;
		$sn=$this->ordersn();
	    $val["sku_id"]=$info["id"];
	
		$val["title"]=get_goods($info['goods_id'],"title");
		$val["total"]=$total;
		$val["price"]=$info['price'];
        $val["num"]=$num;
		$val["order_sn"]=$sn;
		$val["goods_id"]=$goodsid;
		$val["uid"]=$uid;
		Db::name("sales")->insert($val);
		 $arr=explode(',',$info['path']);$specifications="";
						   foreach($arr as $v){
						     $specifications.="&nbsp;".get_specs_title($v) ;
						   }
		 $saleslist =$val["title"] .$specifications ."数量".$val['num']."单价".$val['price']." 小计".$total."</br>";//标识号 
		 $ship_price=get_goods($info['goods_id'],"spress");
		 $data["total"]=$total;
         $data["num"]=$num;
		 $data["ship_price"]=$ship_price;
		 $data["total_money"]=$total+$ship_price;
		 $data["saleslist"]=$saleslist;
         $data["uid"]=$uid;	
         $data['status']=-1;	
		 $data["order_type"]=1;//积分订单
		 $data["order_sn"]=$sn;
		 $data["create_time"]=time();
		 $res=Db::name("order")->insertGetId($data);
		return $res;

    }
   public function ordersn_old(){
		$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'input', 'J');
		$orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%04d%02d', rand(1000, 9999),rand(0,99));
		return $orderSn;
	}

    // 生成支付订单号
   public function ordersn(){
        if ( is_login() ) {
		      $uid=is_login();
		      $code=date('Ymd',time()).time().$uid;
	       return $code;
		}
    }
}
