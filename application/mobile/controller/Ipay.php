<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\mobile\controller;
use think\Db;
                      
class Ipay extends Home {

	public function index() {
		if ($_POST) {
		//页面上通过表单选择在线支付类型，支付宝为alipay 财付通为tenpay
		      
	     		/* 支付设置 */
		   $payment= array(
				
				'aliwappay' => array(
					// 支付宝wap收款账号邮箱
					'email' => C('WAPALIPAYEMAIL'),
					// 加密key，开通支付宝wap账户后给予
					'key' => C('WAPALIPAYKEY'),
					// 合作者ID，支付宝有该配置，开通易宝账户后给予
					'partner' =>C('WAPALIPAYPARTNER')
				)
			);
			$paytype ='aliwappay';
            $pay = new \think\Pay($paytype, $payment[$paytype]);
			if(!empty($_POST['tag'])){
				 $order_no=input('post.tag');//支付订单号
				 $order_no=safe_replace($order_no);//过滤
				 $info=M("order")->where("tag='$order_no'")->find();
                 if($info['status']!=='-1'){
                      $this->error('无效订单');//货到付款订单禁止提交
                 }
				 $money=$info['total_money'];	
				 $body= C('SITENAME')."订单支付";//商品描述
				 $title=C('SITENAME')."订单支付";//设置商品名称
			}
			$vo = new \Think\Pay\PayVo();
			$vo->setBody($body)
			->setFee($money) //支付金额
			->setOrderNo($order_no)//订单号
			->setTitle($title)//设置商品名称
			->setCallback("Wap/Pay/success")/*** 设置支付完成后的后续操作接口 */
			->setUrl(U("Wap/Pay/over")) /* 设置支付完成后的跳转地址*/
			->setParam(array('tag' => $order_no));
			   echo $pay->buildRequestForm($vo);
		}
		else {
			
			$this->meta_title = '支付订单';
			//在此之前goods1的业务订单已经生成，状态为等待支付
			$orderid=safe_replace(input("id"));
			$order=db("order");
			$this->assign('orderid',$orderid);
			$uid=is_login();
	      	$map['uid']=$uid;
			$map['id']=$orderid;
			$info=$order->where($map)->find();
		    $param['order_id'] = $info['id'];
            if(isWeixinBrowser()){
				$this->redirect('Pay/wxpay', $param);
			}
            else{
           
		       $this->assign('info',$info);
			   return $this->fetch();	
			}
		 }
		}

		//支付回调地址 (未生效)
	   public function wxpay(){
		   $order_id=input('order_id',0,'intval'); 
		   /* 标识正确性检测 */
		   if(!( $order_id && is_numeric( $order_id))){
		     $this->error('ID错误！');
		   }	
//		   if(isset($order_id)){
//            $param = array();
//            $param['order_id'] = $order_id;
//            hook('Wxpay', $param); 
//          } 
           include(ROOT_PATH.'extend/WxPayPubHelper.WxPayPubHelper');
           //使用jsapi接口
		   $jsApi = new \JsApi_pub(); 
             
            //=========步骤1：网页授权获取用户openid============
            if (!isset($_GET['code']))
            { 
			
                //触发微信返回code码
                $url = $jsApi->createOauthUrlForCode(\WxPayConf_pub::JS_API_CALL_URL.'/order_id/'.$order_id);
                Header("Location: $url");
            }else
            {
                //获取code码，以获取openid
                $code = $_GET['code'];
                $jsApi->setCode($code);
                $openid = $jsApi->getOpenId();
            }
			$map['uid']=is_login();
			$map['id']=$orderid;
            $info = db('Order')->where($map)->find();
            if(empty($info) || $info['is_pay'] ==2){
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
            $out_trade_no = $info['tag'];
            $unifiedOrder->setParameter("out_trade_no", "$out_trade_no");//商户订单号
            $unifiedOrder->setParameter("total_fee", "$c");//总金额
            $unifiedOrder->setParameter("notify_url",\WxPayConf_pub::NOTIFY_URL.'/order_id/'.$order_id);//通知地址
            $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
            $prepay_id = $unifiedOrder->getPrepayId();
            //=========步骤3：使用jsapi调起支付============
            $jsApi->setPrepayId($prepay_id);
            $jsApiParameters = $jsApi->getParameters();
			$wxconf = json_decode($jsApiParameters, true);
            if ($wxconf['package'] == 'prepay_id=') {
               // $this->error('当前订单存在异常，不能使用支付'); dump($prepay_id);
            }
            $this->assign('res', $res);
			
            $this->assign('jsApiParameters', $jsApiParameters);
           
            $this->display('index');
		}
       //支付成功后异步通知函数
         public function notify()
    {
         vendor('WxPayPubHelper.WxPayPubHelper');
		 //使用通用通知接口
        $notify = new \Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        
        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        $id=safe_replace(input("order_id"));
		 /* 标识正确性检测 */
		if(!($id && is_numeric($id))){
		   $this->error('文档ID错误！');
		}	
		  $order=model("order");
          $data['status'] =1;
	      $data['ispay'] =2;
          $order->where("id='$id'")->update($data);
		
		echo $returnXml;
        
        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======
        
        //以log文件形式记录回调信息
 //         $log_ = new Log_();
       
        
        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                log_result($log_name,"【通信出错】:\n".$xml."\n");
            }
            elseif($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                log_result($log_name,"【业务出错】:\n".$xml."\n");
            }
            else{
                //此处应该更新一下订单状态，商户自行增删操作
                log_result($log_name,"【支付成功】:\n".$xml."\n");
            }
        
            //商户自行增加处理流程,
            //例如：更新订单状态
            //例如：数据库操作
            //例如：推送支付完成信息
        }
    }


     
	  //微信支付成功
      public function wx_success() {
	      $orderid=safe_replace(input("orderid"));
		  $order=db("order");
		  $this->assign('orderid',$orderid);
		  $map['uid']=is_login();
		  $map['id']=$orderid;
		  $info=$order->where($map)->find();
	      $this->assign('info',$info);
	      return $this->fetch('success');
	  
	  }
     
	  //货到付款提交成功
	  public function hd_success() {
	      $orderid=safe_replace(input("orderid"));
		  $order=model("order");
		  $this->assign('orderid',$orderid);
		  $map['uid']=is_login();
		  $map['id']=$orderid;
		  $info=$order->where($map)->find();
          $data['status'] =1;
	      $data['ispay'] =-1;
          $order->where($map)->update($data);
	      $this->assign('info',$info);
		  return $this->fetch('success');
	  
	 }
	 public function main() {	  
	     $tag = I('get.order_id');
         $param['order_id'] = $tag;
         hook('Wxpay', $param);  
	  }
	 public function failure() {	  
	        $orderid=safe_replace(I("orderid"));
			$order=db("order");
			$this->assign('orderid',$orderid);
			$info=$order->where("orderid='$orderid'")->find();
			$this->assign('info',$info);
		   return $this->fetch();
	  
	  }
		/**
		* thinkpay支付成功
		* @param type $money
		* @param type $param
		*/
	    public function successs($money, $param) {
			
			if (session("pay_verify") == true) {
				session("pay_verify", null);
				session('param', $param);
				 
				//处理订单
				$data = array('status'=>'1','ispay'=>'2');//订单已经支付,状态为已提交
				db('order')->where(array('tag' => $param['tag']))->setField($data);
						
				// 发送邮件
				$uid=db("pay")->where(array('out_trade_no' => $param['tag']))->getField('uid');
				$mail=get_email($uid);//获取会员邮箱
				$title="支付提醒";
				$content="您在<a href=\"".C('DAMAIN')."\" target='_blank'>".C('SITENAME').'</a>支付了订单，交易号'.$param['order_id'];
				   if( C('MAIL_PASSWORD')){
					   SendMail($mail,$title,$content);
				   }
			}
			else {
			  E("Access Denied");
			}
		 }

	public function over() {
	    addWeixinLog ( "wap支付完成" .  var_export(session("param"), true )  );; 
		if (session("param")) {
			$param=session("param");	
			$tag=safe_replace($param['tag']);		
			session("param", null);
			$order=M("order");
			$info=$order->where("tag='$tag'")->find();
			$this->assign('info',$info);
			$this->meta_title = '支付成功';
			$this->display('success');
		}
	}
     //余额支付
	public function usecount() {
		if($_POST){
		//页面上通过表单选择在线支付类型，支付宝为alipay 财付通为tenpay
		        /* 支付设置 */
		
			$uid=session_uid(); 
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
			$total_fee=$info['total_money'];
		
            $where["id"]=$uid;
			$ucenter= db("ucenterMember")->where($where)->find(); 
			$account=$ucenter["account"];
			
				 //余额支付
				if($account>=$total_fee){
				  $save["account"]=$account-$total_fee;
                  db("ucenterMember")->where($where)->update($save); 
                  $update["status"]=1;
                  $update["ispay"]=1;
				  $update["paytype"]=1;
				  $update["pay_money"]=$total_fee;//已支付金额
                  db("order")->where($map)->update($update);
						//保存支付信息
					$data["out_trade_no"]=$info["order_sn"];
					$data["money"]=$update["wait_pay_money"];
					$data["uid"]=$uid;
					$data["paytype"]=$update["paytype"];
					$data["model"]="order";//模型为订单
					db("pay")->insert($data);
				    $this->success("支付成功");
				} else{
				    $this->error("余额不足");
				}
				
		}
	}	
}
