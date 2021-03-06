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
 * 支付模型
 */
class Pay extends Model{

    //货到付款，余额支付处理
  	public function deal(){
		    $uid=is_login();
			$map["uid"]=$uid;
			$id=input('id');
			if(!($id && is_numeric($id))){
				   $this->error('用户ID错误！');return false;
			}
			$map["id"]=$id;	
			$info= db("Order")->where($map)->find(); 
			if(!$info){
				$this->error( "订单不存在");return false;
			} 
			if($info["status"]==1){
				$this->error= "订单已支付";return false;
			} 
			$total_fee=$info['total_money'];
			
	   if($_POST["type"]=="1"){
		//页面上通过表单选择在线支付类型，支付宝为alipay 财付通为tenpay
		        /* 支付设置 */
            $where["id"]=$uid;
			$ucenter= db("ucenterMember")->where($where)->find(); 
			$account=$ucenter["account"];
			 //余额支付
			if($account<$total_fee){
				$this->error="余额不足";return false;
			}
				  $save["account"]=$account-$total_fee;
                  db("ucenterMember")->where($where)->update($save); 
                  $update["status"]=1;
                  $update["update_time"]=time();
				  $update["paytype"]=1;//余额支付
				 
                  db("order")->where($map)->update($update);
					
					//更新支付支付信息
				    $where["out_trade_no"]=$info["order_sn"];
					$where["uid"]=$uid;
					$data["order_id"]=$id;
					$data["status"]=1;
					$data["paytype"]=1;
					$data["model"]="order";//模型为订单
					$data["update_time"]=$update["update_time"];
					db("pay")->where($where)->update($data);


                    //余额消费日志信息
					unset($data);		//
					
					$data["money"]=$total_fee;
					$data["type"]=0;//-
					$data["content"]="余额支付订单";
					$data["create_time"]=time();
					$data["uid"]=$uid;
					$data["total"]=$save["account"];
					$url=url('pay/over?id='.$id);
					db("accountLog")->insertGetId($data);
				
		}
		if($_POST["type"]=="2"){
		
		        /* 支付设置 */
                  $update["status"]=1;
				  $update["paytype"]=5;
				  $update["update_time"]=time();
                  $res=db("order")->where($map)->update($update); 


					  //保存支付信息
					$where["out_trade_no"]=$info["order_sn"];
					$where["uid"]=$uid;
					
					$data["status"]=1;
					$data["paytype"]=5;
					$data["model"]="order";//模型为订单
					$data["update_time"]=$update["update_time"];
					db("pay")->where($where)->update($data);
		}
		       
      //拼团订单处理
      if(C("pin")&&$info["order_type"]==2){
	      unset($where); unset($data);
		  $where["goods_id"]=$info["goods_id"];
		  $where2['id']=$info["goods_id"];
          $goods=db("goods")->where($where2)->find();
		  $pin=db("pin")->where($where)->find();
	      if(!$pin){
	              
					$data["uid"]=$uid;//团长
					$data["goods_id"]=$info["goods_id"];
					$data["title"]=$goods["title"];
					$data["status"]=1;//运行中
					$data["max"]=$goods["pin_max_num"];//最大数量
					$data["num"]=$goods["pin_max_num"]-1;//剩余数量
					$data["create_time"]=time();
					db("pin")->insert($data);
			  
			  unset($map);
			
			 $map["goods_id"]=$info["goods_id"];
             $orders["pin_status"]=1;
			 db("order")->where($map)->update($orders); 
	      }
		  if($pin["num"]>1){
		     $data["num"]=$pin["num"]-1;//拼团未完成
		     db("pin")->where($where)->save($save);
			  unset($map);
			
			 $map["goods_id"]=$info["goods_id"];
             $orders["pin_status"]=1;
			 db("order")->where($map)->update($orders); 
		  }
		  if($pin["num"]==1){
		     $data["num"]=$pin["num"]-1;
			 $data["status"]=2;//拼团成功待发货
			 $data["end_time"]=time();
		     db("pin")->where($where)->save($save);
			 unset($map);
			
			 $map["goods_id"]=$info["goods_id"];
             $orders["pin_status"]=2;
			 db("order")->where($map)->update($orders); 
		  }
	  }
       //分销订单处理
		if(C("fenxiao")){
		    unset($where); unset($data);
		    $where["id"]=$uid;
			$this->getParents($uid,$total_fee);
		
		
		}
         unset($where);
          $where["out_trade_no"]=$info["order_sn"];
		  $where["uid"]=$uid;
			$info=Db::name('pay')->where($where)->find();	  
		return $info['id'];
	} 

   	public function modify($out_trade_no){	
		   
            $map['out_trade_no']=safe_replace($out_trade_no);//用户id

	       $info =db("Pay")->field(true)->where($map)->find();
		   if(!$info){
			  return false; 
		   }
		  $model=$info["model"];
		  $uid=$info["uid"];
		  //$map["uid"]=is_login();
          $money=safe_replace($info["total_money"]);
		  $type=safe_replace($info["type"]);
		  $uid=safe_replace($info["uid"]);
		  $UcenterMember=db("UcenterMember"); 
		 
		  if($type=="1"&& $info['status'] =="1"){
			  //充值会员账户
		     $u["id"]=$uid;
		     $in=$UcenterMember->where($u)->find(); 
			 $save["account"]=$in["account"]+$info["total_money"];
			 $UcenterMember->where($u)->update($save);
			
			
		     $save2["uid"]=$uid;
             $save2["type"]=1;
			 $save2["money"]=$info["total_money"];;//充值后剩余金额
			 $save2["create_time"]=time();
			 $save2["content"]="充值";
			 $save2["total"]=$in["account"]+$info["total_money"];;//充值后剩余金额
             db("account_log")->insert($save2); 
			 //addMoneyLog($info["total_money"],$uid,1,"会员充值");
			
		  }
		  //购物车立即购买订单支付
		  if($type=="2"&& $info['status'] =="1"){
		     $map2["id"]=$info["order_id"];
		     $map2["uid"]=$uid;
			 $save2["status"]=1;//支付完成
			 $save2["ispay"]=2;//支付完成
			 $save2["update_time"]=time();
             $res=db($model)->where($map2)->update($save2);
			 //$openid=get_openid_by_uid($uid);	
			 //$re=sendTplorder($openid,$v["total_money"],$v["lists"]);//发送模板消息	 
			        
		  }   
		  //拼团订单处理
		  unset($map);
          $map["id"]=$info["order_id"]; $map["uid"]=$uid;
           unset($info);
          $info =db("order")->field(true)->where($map)->find();
		   if(!$info){
			  return false; 
		   }
		  if(C("pin")&&$info["order_type"]==2){
	      unset($where); unset($data);
		  $where["goods_id"]=$info["goods_id"];
		  $where2['id']=$info["goods_id"];
          $goods=db("goods")->where($where2)->find();
		  $pin=db("pin")->where($where)->find();
	      if(!$pin){
	              
					$data["uid"]=$uid;//团长
					$data["goods_id"]=$info["goods_id"];
					$data["title"]=$goods["title"];
					$data["status"]=1;//运行中
					$data["max"]=$goods["pin_max_num"];//最大数量
					$data["num"]=$goods["pin_max_num"]-1;//剩余数量
					$data["create_time"]=time();
					db("pin")->insert($data);
			  
			  unset($map);
			
			 $map["goods_id"]=$info["goods_id"];
             $orders["pin_status"]=1;
			 db("order")->where($map)->update($orders); 
	      }
		  if($pin["num"]>1){
		     $data["num"]=$pin["num"]-1;//拼团未完成
		     db("pin")->where($where)->save($save);
			  unset($map);
			
			 $map["goods_id"]=$info["goods_id"];
             $orders["pin_status"]=1;
			 db("order")->where($map)->update($orders); 
		  }
		  if($pin["num"]==1){
		     $data["num"]=$pin["num"]-1;
			 $data["status"]=2;//拼团成功待发货
			 $data["end_time"]=time();
		     db("pin")->where($where)->save($save);
			 unset($map);
			
			 $map["goods_id"]=$info["goods_id"];
             $orders["pin_status"]=2;
			 db("order")->where($map)->update($orders); 
		  }
	  }     //分销订单处理
		if(C("fenxiao")){
		  
			$this->getParents($uid,$money);
		
		
		}
		  return true;
    } 
	//父类合集
  	public   function getParents($id = 0,$money,$level=1){
	    $map['id'] = $id;
		$data=db("ucenterMember")->where($map)->field("id,pid")->find();
		if(isset($data["pid"])){ 
			$map2['id'] =$data["pid"];
			$uid=$data["pid"];
             $u["id"]=$uid; 
			 $percent=(float)C("l".$level)/100;
			 $money=$money*$percent;
		     $in=db("ucenterMember")->where($u)->find(); 
			 $save["account"]=$in["account"]+$money;
			db("ucenterMember")->where($u)->update($save);
			
			
		     $save2["uid"]=$uid;
             $save2["type"]=3;
			 $save2["money"]=$money;//充值后剩余金额
			 $save2["create_time"]=time();
			 $save2["content"]=$level."级分销提成";
			 $save2["total"]=$save["account"];//充值后剩余金额
             db("account_log")->insert($save2); 
			$this->getParents($uid,$money,$level+1);
        }
		
	}
	public function score(){
	    $goodsid=(int)input('post.id'); // 用intval过滤$_POST['id']
       
		if($goodsid){
		    $map['goods_id']=safe_replace($goodsid);
		}
		$info=db("sku")->where($map)->find();
        if(!$info){
		    error('sku不存在！');
		}
		if(!$info['num']){
		   error('sku库存数量为0！');
		} 
		$uid=is_login(); 
		
		

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
		$val["type"]=1;//积分订单
		$val["uid"]=$uid;
		 db("sales")->insert($val);
		 $saleslist ="{$info["title"]} 数量{$num} 单价{$info['price']} 小计$total</br>";//标识号 
		 $data["total"]=$total;
		 $data["score"]=$total_score;
		 $data["goods_id"]=$goodsid;
		 $data["total_money"]=$total;
		 $data["saleslist"]=$saleslist;
         $data["uid"]=$uid;	
         $data['status']=0;
		 $data["order_type"]=1;//积分订单
		 $data["order_sn"]=$sn;
		 $data["create_time"]=time();
		 $data["update_time"]=time();
		 $res=db("order")->insertGetId($data);
		
		return $res;	 
	}
	public function categoryTree($cid,$money){
		$UcenterMember = db('UcenterMember');
					//递归执行
					$uid=$cid;	
				
					$arr=$this->getParents($uid);//最近的加盟商
				
					$pid=$arr[0];
					
					$map["id"]=$pid;
					$info=$UcenterMember->where($map)->find();
				    $map2["uid"]=$pid;
					$jia=db("jia")->where($map2)->find(); 
					if($money==C("J1")&&$jia["money"]==C("J1")){
					     $jia=C("L1");//50
						
					}
					if($money==C("J1")&&$jia["money"]==C("J2")){
					     $jia=C("L1");
						
					}
					if($money==C("J1")&&$jia["money"]==C("J3")){
					     $jia=C("L1");
						
					}
					if($money==C("J1")&&$jia["money"]==C("J5")){
					     $jia=C("L1");
						
					}
					if($money==C("J2")&&$jia["money"]==C("J1")){
					     $jia=C("L1");
						
					}
					if($money==C("J2")&&$jia["money"]==C("J2")){
					     $jia=C("L1");
						 
					}
					if($money==C("J2")&&$jia["money"]==C("J3")){
					     $jia=C("L2");
						 
					}
					if($money==C("J2")&&$jia["money"]==C("J5")){
					     $jia=C("L2");
						
					}
                    if($money==C("J3")&&$jia["money"]==C("J1")){
					     $jia=C("L1");
						 
					}
                    if($money==C("J3")&&$jia["money"]==C("J2")){
					     $jia=C("L2");
						 
					}
					if($money==C("J3")&&$jia["money"]==C("J3")){
					     $jia=C("L3");
						
					}
					if($money==C("J3")&&$jia["money"]==C("J5")){
					     $jia=C("L3");
						
					}
					 if($money==C("J5")&&$jia["money"]==C("J1")){
					     $jia=C("L1");
						 
					}
                    if($money==C("J5")&&$jia["money"]==C("J2")){
					     $jia=C("L2");
						 
					}
					if($money==C("J5")&&$jia["money"]==C("J3")){
					     $jia=C("L3");
						
					}
					if($money==C("J5")&&$jia["money"]==C("J5")){
					     $jia=C("L5");
						
					}
				   if($jia["money"]==0){
					     $jia=C("L3");
						
					}
					if($jia>0){
					     $save3["profit"]=$info["profit"]+$jia;
					     $UcenterMember->where($map)->save($save3);
				         //加盟费提成
						 $save4["create_time"]=time();
						 $save4["total_money"]=$jia;
						 $save4["uid"]=$pid; 
						 $save4["username"]=$info["username"];
						 $save4["percent"]="100%";
						 $save4["type"]=4;
						 $save4["remark"]="加盟费返佣";
						 $save4["from"]=$uid;
                         $save4["from_username"]=$username;
						 db("profit")->add($save4); 
						
						}
	}
/** 
	*支付宝支付初始化配置
	*/ 
	public function config() {
     
		 $alipay_config = array (
			//应用ID,您的APPID。
		
           
              //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
			'partner'	=> C('alipaypartner'),

			//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号，同上
			'seller_id'	=>C('alipaysellerid'),

			// MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
			'key'=>  C('alipaykey'),

			//签名方式
			'sign_type'=> strtoupper('MD5'),

			//字符编码格式 目前支持 gbk 或 utf-8
			'input_charset'=> strtolower('utf-8'),

			//ca证书路径地址，用于curl中ssl校验
			//请保证cacert.pem文件在当前文件夹目录中
			 'cacert'=> getcwd().'\\cacert.pem',

			//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
			'transport'   => 'http',

			// 支付类型 ，无需修改
			'payment_type'=> "1",
					
			// 产品类型，无需修改
			'service' => "create_direct_pay_by_user",

			// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
			'anti_phishing_key' => "",
				
			// 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
			'exter_invoke_ip' => "",
             //异步通知地址
            'notify_url' => root_url().url('alipay/notify_url'),
			
			//同步跳转
			'return_url' => root_url().url('alipay/return_url'),
			);

	       return $alipay_config;   
    }

}
