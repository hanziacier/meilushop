<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\mobile\controller;
use think\Db;
    //微信支付控制器                  
class Pay extends Home {
      public function pay() {

			$map['id']=safe_replace(input("id"));
			$info=db("order")->where($map)->find();
			if(!$info){
				$this->error( "订单不存在");
			} 
		       $this->assign('info',$info);
			   return $this->fetch();	
			
		
		}

   //显示支付页面
	public function index() {

			$uid=is_login();
	      	$map['uid']=$uid;
			$map['id']=(int)input("id");
			$info=db("order")->where($map)->find();
			if(!$info){
				$this->error( "订单不存在");
			}
			$this->assign('order',$info);
			unset($map);
            $map['out_trade_no']=$info["order_sn"];
            $pay=db('pay')->where($map)->find();
		    $param['id'] = $pay['id'];
			$meta_title = '支付订单';
		    $this->assign('meta_title', $meta_title);
            if( is_weixin()){
				$this->redirect('Pay/wxpay', $param);
			}
            else{
		       $this->assign('info',$pay);
			   return $this->fetch();	
			}
		
		}
				//支付回调地址 (未生效)
	   public function wxPay(){
		   $order_id=(int)input('id'); 
		   /* 标识正确性检测 */
		   if(!( $order_id && is_numeric( $order_id))){
		     $this->error('ID错误！');
		   }	
//		   if(isset($order_id)){
//            $param = array();
//            $param['order_id'] = $order_id;
//            hook('Wxpay', $param); 
//          } 
           include(ROOT_PATH.'extend/WxPayPubHelper/WxPayPubHelper.php');
           //使用jsapi接口
		   $jsApi = new \JsApi_pub(); 
             
            //=========步骤1：网页授权获取用户openid============
            if (!isset($_GET['code']))
            { 
			
                //触发微信返回code码
                $url = $jsApi->createOauthUrlForCode(\WxPayConf_pub::JS_API_CALL_URL.'/id/'.$order_id);
                Header("Location: $url");
            }else
            {
                //获取code码，以获取openid
                $code = $_GET['code'];
                $jsApi->setCode($code);
                $openid = $jsApi->getOpenId();
            }
			 if(empty( $openid)){
                    dump('该订单不存在或已支付'.$order_id);
                    exit();
                }
            $info = db('pay')->where('id='.$order_id)->find();
            if(empty($info) || $info['status'] ==1){
                    dump('该订单不存在或已支付'.$order_id);
                    exit();
                }
                $this->assign('info', $info);
                $a = $info['total_money'];
                $b = 100;
                $c = $a * $b;
            
            //=========步骤2：使用统一支付接口，获取prepay_id============
            //使用统一支付接口
            $unifiedOrder = new \UnifiedOrder_pub();
            $openid =$openid?$openid:get_openid();
            $unifiedOrder->setParameter("openid","$openid");//商品描述
            $unifiedOrder->setParameter("body","订单支付");//商品描述
            //自定义订单号，此处仅作举例
            $timeStamp = time();
//             $out_trade_no = \WxPayConf_pub::APPID."$timeStamp";
            $out_trade_no = $info['out_trade_no'];
            $unifiedOrder->setParameter("out_trade_no", "$out_trade_no");//商户订单号
            $unifiedOrder->setParameter("total_fee", "$c");//总金额
            $unifiedOrder->setParameter("notify_url",\WxPayConf_pub::NOTIFY_URL.'/id/'.$order_id);//通知地址
            $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
            $prepay_id = $unifiedOrder->getPrepayId(); 
            //=========步骤3：使用jsapi调起支付============
            $jsApi->setPrepayId($prepay_id);
            $jsApiParameters = $jsApi->getParameters();
			$wxconf = json_decode($jsApiParameters, true);
            if ($wxconf['package'] == 'prepay_id=') {
                $this->error('当前订单存在异常，不能使用支付'); dump($prepay_id);
            }
            //$this->assign('res', $res);
			
            $this->assign('jsApiParameters', $jsApiParameters);
            if($info["type"]==1){
				 
				 $tml="pay";
				 
			 }
			 else{
				 $tml="index";
				
				 
			 }
			 
			 $map2["order_sn"]=$out_trade_no;
			//$map["uid"]=is_login();
			//充值订单
		
		     $order = db('order')->where($map2)->find();
		  
			 $this->assign('order', $order);
            return $this->fetch($tml);
		}

	
		
	
            //支付成功后异步通知函数
      public function notify(){
         include(ROOT_PATH.'extend/WxPayPubHelper/WxPayPubHelper.php');
		 //使用通用通知接口
         $notify = new \Notify_pub();  
         $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
         $notify->saveData($xml);
         if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();		
		echo $returnXml;        
        if($notify->checkSign() == TRUE){
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                //log_result($log_name,"【通信出错】:\n".$xml."\n");
            }
            else if($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
               // log_result($log_name,"【业务出错】:\n".$xml."\n");
            }
            else{
					$id=safe_replace(input("id"));
		            $c["id"]=$id;
		            $info=db("pay")->where($c)->find();
		            if($info["status"]=="1"){
                           return false;
		            }
					$save["status"]=1;
					$save["update_time"]=time();
					db("pay")->where($c)->update($save);
					$this->update($info["out_trade_no"]);
                //此处应该更新一下订单状态，商户自行增删操作
                //log_result($log_name,"【支付成功】:\n".$xml."\n");
            }
        
            //商户自行增加处理流程,
            //例如：更新订单状态
          
			//例如：数据库操作
            //例如：推送支付完成信息
		
        }

    }
     //微信支付完成统一订单处理
public function update($out_trade_no){	
		    //$out_trade_no =safe_replace($_REQUEST['out_trade_no']);
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
		 
		  return true;
    } 
		 
  
     
	  //货到付款提交成功
	  public function over() {
		  $id=input('id');
		  if(!($id && is_numeric($id))){
				 $this->error('用户id错误！');
		  }
		  $map['uid']=is_login();
		  $map['id']=$id;
		  $info=db("pay")->where($map)->find();
		  if(!$info){
			$this->error( "订单不存在");
		  }
		   $map2["order_sn"]=$info['out_trade_no'];
			//$map["uid"]=is_login();
			//充值订单
		
		     $order = db('order')->where($map2)->find();
		  
			 $this->assign('order', $order);
	      $this->assign('info',$info);
		  return $this->fetch("success");
	  
	 }
	 	   //货到付款支付
	  public function huopay() {
		  $id=input('id');
		  if(!($id && is_numeric($id))){
				 $this->error('用户id错误！');
		  }
		  $map['uid']=is_login();
		  $map['id']=$id;
		  $info=db("order")->where($map)->find();
		  if(!$info){
			$this->error( "订单不存在");
		  } 
		  if($info['status']){
			$this->error( "订单已支付");
		  }
		  
                  $update["status"]=1;
                  $update["ispay"]=1;
				  $update["paytype"]=5;
                  $res=db("order")->where($map)->update($update); 
					  //保存支付信息
					$where["out_trade_no"]=$info["order_sn"];
					$where["uid"]=is_login();
					$data["status"]=1;
					$data["paytype"]=5;
					$data["update_time"]=time();
					db("pay")->where($where)->update($data);
				    $url=url('pay/over?id='.$id);
				  
	      if($res){
             $this->success( "支付成功",$url);
		  } else{
			 $this->error("支付失败");
		  }
	 }


	 public function failure() {	  
	      $id=safe_replace(input('sn'));
		  
		  $map['uid']=is_login();
		  $map['out_trade_no']=$id;
		  $info=db("pay")->where($map)->find();
		  if(!$info){
			$this->error( "订单不存在");
		  }
		  $map2["order_sn"]=$id;
			//$map["uid"]=is_login();
			//充值订单
		
		     $order = db('order')->where($map2)->find();
		  
			 $this->assign('order', $order);
		  $this->assign('info',$info);
		  return $this->fetch();
	 }
	
	
     //余额支付
	public function usecount() {
	    if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		if($_POST){
		//页面上通过表单选择在线支付类型，支付宝为alipay 财付通为tenpay
		        /* 支付设置 */
		
			$uid=is_login();
			$map["uid"]=$uid;
			$id=input('id');
			if(!($id && is_numeric($id))){
				   $this->error('用户ID错误！');
			}
			$map["id"]=$id;	
			$info= db("order")->where($map)->find(); 
			if(!$info){
				$this->error( "订单不存在");
			} 
			if($info["status"]==1){
				$this->error( "订单已支付");
			} 
			$total_fee=$info['total_money'];
		
            $where["id"]=$uid;
			$ucenter= db("ucenterMember")->where($where)->find(); 
			$account=$ucenter["account"];
			
				 //余额支付
				if($account>=$total_fee){
				  $save["account"]=$account-$total_fee;
                  db("ucenterMember")->where($where)->update($save); 
                  $update["status"]=1;
                  $update["update_time"]=time();
				  $update["paytype"]=1;//余额支付
				  $update["pay_money"]=$total_fee;//已支付金额
                  db("order")->where($map)->update($update);
						//保存支付信息
					unset($where);
					$where["out_trade_no"]=$info["order_sn"];
					$where["uid"]=is_login();
					$data["status"]=1;
					$data["paytype"]=1;//余额支付
					$data["update_time"]=time();
					db("pay")->where($where)->update($data);
                    //余额消费日志信息
					unset($data);		//
					
					$data["money"]=$total_fee;
					$data["type"]=0;//-
					$data["content"]="余额支付订单";
					$data["create_time"]=time();
					$data["uid"]=$uid;
					db("accountLog")->insertGetId($data);
				    $this->success("支付成功");
				} else{
				    $this->error("余额不足");
				}
				
		}
	}	
}
