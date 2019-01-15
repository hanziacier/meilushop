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
namespace app\index\model;
use think\Model;
use think\Db;
/**
 * 支付模型
 */
class Pay extends Model{

    
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
