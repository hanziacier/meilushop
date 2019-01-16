<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\mobile\controller;
use think\Db;
                      
class Wallet extends Home {
  
	
	public function index() {

        if ($_POST) {
		    $money=safe_replace(input('money'));
			if(!$money){
				$this->error('金额不能为空');//货到付款订单禁止提交
			}
            $type=input('type'); 
		    /* 标识正确性检测 */
		    if(!( $type && is_numeric( $type))){
		       $this->error('充值方式错误！');
		    }
		   //支付宝支付
            if($type==1){
			   $param['money'] = $money;
			   $this->redirect('Alipay/add', $param);
			
			}
	        else if($type==2){
				
				$uid=is_login();
                $out_trade_no=$this->ordersn();//创建订单号 
				//保存支付信息
			    $data["out_trade_no"]= $out_trade_no;
			    $data["total_money"]=$money;
			    $data["uid"]=$uid;
			    $data["model"]="account";
				$data["type"]=1;
			    $id=db("pay")->insertGetId($data);
			    $param['id'] = $id;
			    $this->redirect('pay/wxpay', $param);
			}
			else{
			    $this->error('充值方式错误！');
			}


		 }else{
			   return $this->fetch();	
			
		 }
	}   // 生成支付订单号
   public function ordersn(){
        if ( is_login() ) {
		      $uid=is_login();
		      $code=date('Ymd',time()).time().$uid;
	       return $code;
		}
    }     
}
