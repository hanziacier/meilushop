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
namespace app\mobile\Controller;
use think\Controller;

class Alipay extends Home {
 
	//表单提交支付宝wap支付
	public function index() {
		
	           $this->error('请联系官方授权后获取支付接口！');
			
					
	
		
	
	 }
     public function ordersn(){
        if ( is_login() ) {
		      $uid=is_login();
		      $code=date('Ymd',time()).time().$uid;
	       return $code;
		}
    }     
      //充值
	 public function add() {
	     if (!is_login() ) {
			   $this->redirect("User/login" );
		  }
			 $this->error('请联系官方授权后获取支付接口！');	
	
    }

    public function return_url() {	
		include(ROOT_PATH.'extend/alipaywap/wappay/service/AlipayTradeService.php');
		$config=$this->config();
			
				   //计算得出通知验证结果
				   
		 $arr=$_GET;
$alipaySevice = new \AlipayTradeService($config); 
$result = $alipaySevice->check($arr);
		if($result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			  
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

			//商户订单号
			$out_trade_no = safe_replace($_GET['out_trade_no']);
                
			//支付宝交易号
			$trade_no =safe_replace($_GET['trade_no']);

			
            $uid=is_login();
			$map['uid']=$uid;//用户id
			$map['out_trade_no']=safe_replace($out_trade_no);//用户id
            $info=db('pay')->where($map)->find();
			if($info['status']) {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					$this->meta_title = '支付成功';
		            $this->assign('meta_title',$this->meta_title);
					 $url=url('pay/over?id='.$info["id"]);
		            $this->redirect($url);
					//如果有做过处理，不执行商户的业务程序
			

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
			else {
				//验证失败
				//如要调试，请看alipay_notify.php页面的verifyReturn函数
				 $url=url('pay/failure?id='.$info["out_trade_no"]);
		         $this->redirect($url);
			}
		}

		}
	
	/**
		* 订单支付成功
		* @param type $money
		* @param type $param
		*/
	public function notify_url() {
        include(ROOT_PATH.'extend/alipaywap/wappay/service/AlipayTradeService.php');
		//获取配置
		$config=$this->config();
		$arr=$_POST;
		$alipaySevice = new \AlipayTradeService($config); 

		$result = $alipaySevice->check($arr);

		if($result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代

			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			
			//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			
			//商户订单号
			$out_trade_no =safe_replace($_POST['out_trade_no']);
            $map['out_trade_no']=$out_trade_no;//用户id
			//支付宝交易号
			$trade_no = safe_replace($_POST['trade_no']);

			//交易状态
			$trade_status =safe_replace( $_POST['trade_status']);
	        $payinfo =db("Pay")->field(true)->where($map)->find();

			if($_POST['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
					//如果有做过处理，不执行商户的业务程序
					 if ($payinfo['status'] == 1) {
                        
                          echo "已经支付成功";		//请不要修改或删除
                    }	
				//注意：
				//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
			else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
					//如果有做过处理，不执行商户的业务程序
			
                if ($payinfo['status'] == 0) {
                         //支付成功时间
                       $data["update_time"]=time();
                        $data["status"]=1;
                         db("Pay")->where($map)->update($data);
						 $this->update($out_trade_no);
                         
						
                }	
				//注意：
				//付款完成后，支付宝系统发送该交易状态通知

				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
				
			echo "success";		//请不要修改或删除
	
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}
			else {
				//验证失败
				echo "fail";

				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
	  }
	
	   //支付宝统一订单处理
	public function update($out_trade_no){	
		
		 
		  return true;
    } 
		 
	
     
}