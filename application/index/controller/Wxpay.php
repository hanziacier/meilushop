<?php
/**
 * @link http://blog.kunx.org
 * @author kunx <kunx-edu@qq.com>
 * 微信扫码支付示例代码
 */
namespace app\index\controller;

class Wxpay extends Home {

    /**
     * 用户可以看到的订单支付表单页面，目前只有一个二维码而已。
     * @return type
     */
    public function index() {
 
		include(ROOT_PATH.'extend/wxpay/Autoloader.php');
        $notify = new \NativePay();
        //模式二
        /**
         * 流程：
         * 1、调用统一下单，取得code_url，生成二维码
         * 2、用户扫描二维码，进行支付
         * 3、支付完成之后，微信服务器会通知支付成功
         * 4、在支付成功通知中需要查单确认是否真正支付成功（见：wxpayNotify方法）
         */
	if ( !is_login() ) {
				 $this->error('未登录！', url('user/login'));
		} 
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
			if($info["status"]==1){
				$this->error( "订单已支付");
			}
		$total_fee=$info['total_money'];
		$out_trade_no=$info["order_sn"];//过滤
        $input  = new \WxPayUnifiedOrder();
        $input->SetBody("商城订单");
        $input->SetOut_trade_no($out_trade_no);
        $input->SetTotal_fee($total_fee*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 300));//有效期最少5分钟
        $input->SetGoods_tag("6575675");
        
        $url    = url('wxpayNotify', '', true, true);
        $input->SetNotify_url($url);
        
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id(time());
        $result = $notify->GetPayUrl($input);
        $url2   = $result["code_url"];
        $url2   = base64_encode($url2);

        //渲染一个视图，参数用于获取验证码。
        return $this->fetch('', ['text' => $url2]);
    }
    //打赏
	 public function reward() {
	    if(!is_login()) {
			$uid=0;
		}
		//页面上通过表单选择在线支付类型，支付宝为alipay 财付通为tenpay
		        /* 支付设置 */
        else{
			$uid=is_login();
		
		} 
		include(ROOT_PATH.'extend/wxpay/Autoloader.php');
		$id=input('id'); 	
        if(!($id && is_numeric($id))){
		   $this->error('ID错误！');
		}
		$where["id"]=$id;	
		$info= db('document')->where($where)->find();
		if(!$info){
		    $this->error('文章不存在！');
		}
		$info["price"]=safe_replace(input("total_money"));
        if(!$info["price"]){
		    $this->error('金额错误！');
		}
		 $out_trade_no=$this->ordersn();
		 $data["total_money"]=$info["price"];
		 $data["content"]=$info["title"];
         $data["uid"]=$uid;
         $data['status']=0;
		 $data["order_sn"]=$out_trade_no;
		 $data["create_time"]=time(); 
		 $data["doc_id"]=$id;
		 $data["update_time"]=time();
		 $res=db("order")->insertGetId($data);
		 unset($data);
        
			$pay_money=$info["price"];
			
            $out_trade_no=time().rand(12,57).$uid;//过滤 
				//保存支付信息
			$data["out_trade_no"]= $out_trade_no;
			$data["total_money"]=$pay_money;
			$data["uid"]=$uid;
			$data["model"]="reward";
			db("pay")->insert($data);

			$body= C('SITENAME')."订单";//商品描述
			$subject=C('SITENAME')."订单-".$out_trade_no;//设置商品名称	
			$notify = new \NativePay();
			 $input  = new \WxPayUnifiedOrder();
        $input->SetBody("商城订单");
        $input->SetOut_trade_no($out_trade_no);
        $input->SetTotal_fee($pay_money);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 300));//有效期最少5分钟
        $input->SetGoods_tag("blog.kunx.org");
        
        $url    = root_url().url('wxpayNotify');
        $input->SetNotify_url($url);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("100");
        $result = $notify->GetPayUrl($input);
		if(empty($result["code_url"])){
		   $this->error('微信支付配置错误！');
		}
        $url2   = $result["code_url"];
        $url2   = base64_encode($url2);
       
        //渲染一个视图，参数用于获取验证码。
        return $this->fetch('', ['text' => $url2]);
			
		
	 } 
    /**
     * 二维码。
     * @param string $text
     * @return png
     */
    public function qrcode($text) {
        \think\Loader::import('qrcode.qrcode');
        $text = base64_decode($text);
        return \QRcode::png($text);
        exit;
    }
	     // 生成支付订单号
   public function ordersn(){
        if ( is_login() ) {
		      $uid=is_login();
		      $code=date('Ymd',time()).time().$uid;
	       return $code;
		}
    }
    /**
     * 微信通知页面。
     */
    public function wxpayNotify() {
       	include(ROOT_PATH.'extend/wxpay/Autoloader.php');
        
        //在PayNotifyCallBack中重写了NotifyProcess，会发起一个订单支付状态查询，其实也可以不去查询，因为从php://input中已经可以获取到订单状态。file_get_contents("php://input")
        //$notify = new \WxPayNotify();
        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
        $result = $notify->GetValues();
        if ($result['return_code'] == 'SUCCESS') {
            //订单支付完成，修改订单状态，发货。

			//商户订单号
			$out_trade_no =safe_replace($result['out_trade_no']);
			 $map['out_trade_no']=safe_replace($out_trade_no);//用户id
	        $payinfo =db("Pay")->field(true)->where($map)->find();
			 if ($payinfo['status'] == 1) {
                        
                          echo "已经支付成功";		//请不要修改或删除
						  return false;
              }	

			   $data["update_time"]=time();
               $data["status"]=1;
			   $data["paytype"]=6;
                db("Pay")->where($map)->update($data);
				 $Pay=new \app\common\model\Pay;
		         $res=$Pay->modify($out_trade_no) ;
			     
        }
      
    }


}
