<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\mobile\Controller;
use think\Db;
namespace Wap\Controller;
use Think\Controller;
class PublicController extends HomeController {

    /**
     * 支付结果返回
     */
    public function notify() {
        $apitype = I('get.apitype');
        $apitype=safe_replace($apitype);//过滤
         /* 支付设置 */
	        $payment= array(
        'tenpay' => array(
            // 加密key，开通财付通账户后给予
            'key' =>  C('TENPAYKEY'),
            // 合作者ID，财付通有该配置，开通财付通账户后给予
            'partner' => C('TENPAYPARTNER')
        ),
        'alipay' => array(
            // 收款账号邮箱
            'email' =>C('ALIPAYEMAIL'),
            // 加密key，开通支付宝账户后给予
            'key' => C('ALIPAYKEY'),
            // 合作者ID，支付宝有该配置，开通易宝账户后给予
            'partner' => C('ALIPAYPARTNER')
        ),
		'aliwappay' => array(
					// 支付宝wap收款账号邮箱
					'email' => C('WAPALIPAYEMAIL'),
					// 加密key，开通支付宝wap账户后给予
					'key' => C('WAPALIPAYKEY'),
					// 合作者ID，支付宝有该配置，开通易宝账户后给予
					'partner' =>C('WAPALIPAYPARTNER')
				),
        'palpay' => array(
            'business' =>  C('PALPAYPARTNER')
        ),
        'yeepay' => array(
            'key' =>  C('YEEPAYPARTNER'),
            'partner' =>  C('YEEPAYKEY')
        ),
        'kuaiqian' => array(
            'key' =>  C('KUAIQIANPARTNER'),
            'partner' =>  C('KUAIQIANKEY')
        ),
        'unionpay' => array(
            'key' =>  C('UNIONPARTNER'),
            'partner' =>  C('UNIONKEY')
        )
    );
        $pay = new \Think\Pay($apitype, $payment[$apitype]);
        if ($_POST && !empty($_POST)) {
            $notify = $_POST;
        } elseif (IS_GET && !empty($_GET)) {
            $notify = $_GET;
            unset($notify['method']);
            unset($notify['apitype']);
        } else {
            exit('Access Denied-1');
        }
        //验证
        if ($notify) {
            //获取订单信息
           if ($apitype=='alipay') {
			   $info = $this->setInfo($notify); 
              }
           else {
                  $pay->verifyNotify($notify);
                  $info = $pay->getInfo();
				  }
            addWeixinLog ( "wap支付成功" .  var_export($info, true )  );; 
			if ($info['status']) {
                $payinfo = db("Pay")->field(true)->where(array('out_trade_no' => $info['out_trade_no']))->find();
                if ($payinfo['status'] == 0 && $payinfo['callback']) {
                    session("pay_verify", true);
                    $check = R($payinfo['callback'], array('money' => $info['money'], 'param' => unserialize($payinfo['param'])));
                    if ($check !== false) {
                        db("Pay")->where(array('out_trade_no' => $info['out_trade_no']))->setField(array('update_time' => time(), 'status' => 1));
                    }
                }
                if (input('get.method') == "return") {
                    redirect($payinfo['url']);
                } else {
                    $pay->notifySuccess();
                }
            } else {
                $this->error("支付失败-2！");
            }
        } else {
            E("Access Denied-2");
        }
    }
	//支付宝签名验证
   protected function setInfo($notify) {
        $info = array();
        //支付状态
        $info['status'] = ($notify['trade_status'] == 'TRADE_FINISHED' || $notify['trade_status'] == 'TRADE_SUCCESS') ? true : false;
        $info['money'] = $notify['total_fee'];
        $info['out_trade_no'] = $notify['out_trade_no'];
        return $info;
    }
}
