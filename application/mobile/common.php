<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
use think\Db;

function is_weixin() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}

/**
 * 标签库解析广告位标签
 * @param int $place   传入广告的位置
 * @return string
 */
function  getEqual($id){
	$map['goods_id']=$id;
	$list=Db::name("comment")->where($map)->select();
	
	if(!$list){
	  return 0;
	}
	$count=Db::name("comment")->where($map)->count();
	$total="";
	foreach($list as $k=>$v){
	 $total+=$v["des"];
	}
    return ceil($total/$count);  
}
// 获取当前用户的OpenId
function get_openid($openid = NULL) {
	$token = "";
	if ($openid !== NULL) {
		session ( 'openid_' . $token, $openid );
	} elseif (! empty ( $_REQUEST ['openid'] )) {
		session ( 'openid_' . $token, $_REQUEST ['openid'] );
	}
	$openid = session ( 'openid_' . $token );

	if (empty ( $openid )) {
		return - 1;
	}
 	
	return $openid;
}

function apiLists($model,$map="",$num="10",$listsort="id desc",$p="1",$field=""){ 
		 $res["list"]=db($model)->where($map)->field($field)->order($listsort)->page($p,$num)->select();
		 $res["count"]=db($model)->where($map)->field($field)->order($listsort)->count();
		 $res["pagenum"]= ceil($res["count"]/$num);
		return $res;
}

function get_category_title($id){
   
	$map['id']=$id;
	$info=db("category")->where($map)->find();
    return $info['title'];  
}	

/**
 * 创建财付通支付链接
 * @param  string $out_trade_no 支付订单号
 * @param  string $total 订单总金额
 * @return integer    段落总数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function create_tencent_url($out_trade_no,$money){	
$config=array(
     'partner' =>C('WAPTENCENTPARTNER'),   //商户号,这里是你在成功申请财付通接口后获取到的PID,通过后台配置读取；
    'key'=>C('WAPTENCENTKEY'),//这里是你在成功申请支付宝接口后获取到的Key.通过后台配置读取
    //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
    'notify_url'=>get_index_url().U("Mobile/WapTenpay/payNotifyUrl"), 
    //这里是页面跳转通知url，提交到项目的Pay控制器的returnurlnn方法；
     'call_back_url'=>get_index_url().U("Mobile/WapTenpay/payReturnUrl"),
 );

/* 商户号 */
$partner = $config['partner'];

/* 密钥 */
$key = $config['key'];


//商户订单号
$out_trade_no =$out_trade_no;
//商户网站订单系统中唯一订单号，必填

//付款金额
$total_fee = $money;

//4位随机数
//$randNum = rand(1000, 9999);
//订单号，此处用时间加随机数生成，商户根据自己情况调整，只要保持全局唯一就行
//$out_trade_no = date("YmdHis") . $randNum;
//服务器异步通知页面路径
 $notify_url = $config['notify_url']; //服务器异步通知页面路径
//需http://格式的完整路径，不允许加?id=123这类自定义参数

//页面跳转同步通知页面路径
$return_url = $config['call_back_url'];
//需http://格式的完整路径，不允许加?id=123这类自定义参数

/* 创建支付请求对象 */
$reqHandler = new \Think\Tencent\RequestHandler();
$reqHandler->init();
$reqHandler->setKey($key);
//$reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");
//设置初始化请求接口，以获得token_id
$reqHandler->setGateUrl("http://wap.tenpay.com/cgi-bin/wappayv2.0/wappay_init.cgi");


$httpClient = new \Think\Tencent\client\TenpayHttpClient();
//应答对象
$resHandler = new \Think\Tencent\client\ClientResponseHandler();
//----------------------------------------
//设置支付参数 
//----------------------------------------
$reqHandler->setParameter("total_fee", $total_fee);  //总金额
//用户ip
$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);//客户端IP
$reqHandler->setParameter("ver", "2.0");//版本类型
$reqHandler->setParameter("bank_type", "0"); //银行类型，财付通填写0
$reqHandler->setParameter("callback_url", $return_url);//交易完成后跳转的URL
//$reqHandler->setParameter("callback_url", "http://www.qq.com");//交易完成后跳转的URL
$reqHandler->setParameter("bargainor_id", $partner); //商户号
$reqHandler->setParameter("sp_billno", $out_trade_no); //商户订单号
$reqHandler->setParameter("notify_url", $notify_url);//接收财付通通知的URL，需绝对路径
$reqHandler->setParameter("desc", "测试");
$reqHandler->setParameter("attach", "订单支付");


$httpClient->setReqContent($reqHandler->getRequestURL());

//后台调用
if($httpClient->call()) {

	$resHandler->setContent($httpClient->getResContent());
	//获得的token_id，用于支付请求
	$token_id = $resHandler->getParameter('token_id');
	$reqHandler->setParameter("token_id", $token_id);
	
	//请求的URL
	//$reqHandler->setGateUrl("https://wap.tenpay.com/cgi-bin/wappayv2.0/wappay_gate.cgi");
	//此次请求只需带上参数token_id就可以了，$reqUrl和$reqUrl2效果是一样的
	//$reqUrl = $reqHandler->getRequestURL(); 
	  $reqUrl = "http://wap.tenpay.com/cgi-bin/wappayv2.0/wappay_gate.cgi?token_id=".$token_id;
	  
	  
	  }


    return   $reqUrl;
}
 function sendTplStatus($openid,$username,$type) { 
    //$openid="o2wdRwEC3MleBVOR1SH7yNDzJRiE";
    $title="买家订单支付成功,请发货";
    $time=date("Y年m月d日 H:i",time());
    //$remark="我们已收到您的货款，开始为您打包商品，请耐心等待: )";
    $data = array('touser' => $openid,
                  'template_id' =>"2KOzf77ak5apZo3HGq_bIt9PEiSZDzh-wMiss3QWe-8",
                  'url' => $url,
                  'topcolor' => "#7B68EE",
                  'data' => array('first'   => array('value' => urlencode($title),
                                                     'color' => "#743A3A",
                                                      ),
                                   'account'    => array('value' => urlencode($username),
                                                     'color' => "#743A3A",
                                                      ),
                                  
                                  'time'    => array('value' => urlencode($time),
                                                     'color' => "#C4C400",
                                                      ),
                                  'type'    => array('value' => urlencode($type),
                                                     'color' => "#C4C400",
                                                      ),
                                 
                                  'remark'  => array('value' => urlencode($remark),
                                                     'color' => "#C4C400",
                                                      ),

                                  )
                  );
        $tree = urldecode(json_encode( $data ));
        $info = M ( 'member_public' )->find ();
        $url_get = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $info ['appid'] . '&secret=' . $info ['secret']; 
        $ch1 = curl_init ();
        $timeout = 5;
        curl_setopt ( $ch1, CURLOPT_URL, $url_get );
        curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
        $accesstxt = curl_exec ( $ch1 );
        curl_close ( $ch1 );
        $access = json_decode ( $accesstxt, true );//取得access_token
        if (empty ( $access ['access_token'] )) {
            $msg="获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试";
            addWeixinLog ( "access_token通知：" .  var_export($msg, true )  );
            //$this->error ( '获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试。' );
        }
        
        //需要提交的url  
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access ['access_token'];
        $header [] = "content-type: application/x-www-form-urlencoded; charset=UTF-8";      
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $tree);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $res = curl_exec ( $ch );
        curl_close ( $ch );
        $res = json_decode ( $res, true );  
        addWeixinLog ( "订单模板信息：" .  var_export($res, true )  );
        if ($res ['errcode'] == 0) {
            return  '订单支付成功' ;
         return 0;
        } else {
            //$this->success ( '发送失败，错误的返回码是：' . $res ['errcode'] . ', 错误的提示是：' . $res ['errmsg'] );
           return $res ['errcode'];
        }
    }
		// 发送模板消息-订单支付成功
function sendTplorder($openid,$money,$remark) { 
	//$openid="o2wdRwEC3MleBVOR1SH7yNDzJRiE";
	$title="买家订单支付成功,请发货";
	//$remark="我们已收到您的货款，开始为您打包商品，请耐心等待: )";
	$data = array('touser' => $openid,
                  'template_id' =>"mA35ssuhWavj9ba8iFb7hQQAXKaErOwX261aFYgwJhY",
				  'url' => $url,
				  'topcolor' => "#7B68EE",
                  'data' => array('first'	=> array('value' => urlencode($title),
													 'color' => "#743A3A",
													  ),
		                           'orderMoneySum'	=> array('value' => urlencode($money),
													 'color' => "#743A3A",
													  ),
								  
								  'orderProductName' 	=> array('value' => urlencode($remark),
													 'color' => "#C4C400",
													  ),
								 
								  'remark' 	=> array('value' => urlencode($remark),
													 'color' => "#C4C400",
													  ),

                                  )
                  );
		$tree = urldecode(json_encode( $data ));
		$info = M ( 'member_public' )->find ();
		$url_get = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $info ['appid'] . '&secret=' . $info ['secret'];	
		$ch1 = curl_init ();
		$timeout = 5;
		curl_setopt ( $ch1, CURLOPT_URL, $url_get );
		curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
		$accesstxt = curl_exec ( $ch1 );
		curl_close ( $ch1 );
		$access = json_decode ( $accesstxt, true );//取得access_token
		if (empty ( $access ['access_token'] )) {
			$msg="获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试";
			addWeixinLog ( "access_token通知：" .  var_export($msg, true )  );
			//$this->error ( '获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试。' );
		}
		
		//需要提交的url	
		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access ['access_token'];
		$header [] = "content-type: application/x-www-form-urlencoded; charset=UTF-8";		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $tree);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$res = curl_exec ( $ch );
		curl_close ( $ch );
		$res = json_decode ( $res, true );  
		addWeixinLog ( "订单模板信息：" .  var_export($res, true )  );
		if ($res ['errcode'] == 0) {
			return  '订单支付成功' ;
         return 0;
		} else {
			//$this->success ( '发送失败，错误的返回码是：' . $res ['errcode'] . ', 错误的提示是：' . $res ['errmsg'] );
           return $res ['errcode'];
		}
	}
// 发送模板消息-商品已发出通知
function sendTpldelivery($openid,$delivername,$ordername) { 
	//$openid="o2wdRwEC3MleBVOR1SH7yNDzJRiE";
	$title="亲，宝贝已经启程了，好想快点来到你身边";
	$remark="如果疑问，请与官方人员联系".C("MOBILE");
	$data = array('touser' => $openid,
                  'template_id' =>"CgFbtbtZ10RJ84SIzEDJ-gIwv-9mKFnWP17yDRLauRc",
				  'url' => $url,
				  'topcolor' => "#7B68EE",
                  'data' => array('first'	=> array('value' => urlencode($title),
													 'color' => "#743A3A",
													  ),
		                           'delivername'=> array('value' => urlencode($delivername),
													 'color' => "#743A3A",
													  ),
								  
								  'ordername'=> array('value' => urlencode($ordername),
													 'color' => "#C4C400",
													  ),
								 
								  'remark'=> array('value' => urlencode($remark),
													 'color' => "#C4C400",
													  ),

                                  )
                  );
		$tree = urldecode(json_encode( $data ));
		$info = M ( 'member_public' )->find ();
		$url_get = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $info ['appid'] . '&secret=' . $info ['secret'];	
		$ch1 = curl_init ();
		$timeout = 5;
		curl_setopt ( $ch1, CURLOPT_URL, $url_get );
		curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
		$accesstxt = curl_exec ( $ch1 );
		curl_close ( $ch1 );
		$access = json_decode ( $accesstxt, true );//取得access_token
		if (empty ( $access ['access_token'] )) {
			$msg="获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试";
			addWeixinLog ( "access_token通知：" .  var_export($msg, true )  );
			//$this->error ( '获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试。' );
		}
		
		//需要提交的url	
		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access ['access_token'];
		$header [] = "content-type: application/x-www-form-urlencoded; charset=UTF-8";		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $tree);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$res = curl_exec ( $ch );
		curl_close ( $ch );
		$res = json_decode ( $res, true );  
		addWeixinLog ( "订单模板信息：" .  var_export($res, true )  );
		if ($res ['errcode'] == 0) {
			return  '发送成功' ;
         return 0;
		} else {
			//$this->success ( '发送失败，错误的返回码是：' . $res ['errcode'] . ', 错误的提示是：' . $res ['errmsg'] );
           return $res ['errcode'];
		}
	}
// 发送模板消息-订单状态更新
function sendTplOrderStatus($openid,$OrderSn,$OrderStatus) { 
	//$openid="o2wdRwEC3MleBVOR1SH7yNDzJRiE";
	
	$u["openid"]=$openid;
    $in=M('UcenterMember')->where($u)->find();
	$title="尊敬的$in[username]:"; 
	$remark="如果疑问，请与官方人员联系";
	//$result="其他订单信息,物流信息: 圆通速递(上海)快递单号: 8031971890";
	$data = array('touser' => $openid,
                  'template_id' =>"L63JiGz2CbltI_uBk_yWp4SNgi0E3T3ExsCuNgstf8E",
				  'url' => $url,
				  'topcolor' => "#7B68EE",
                  'data' => array('first'	=> array('value' => urlencode($title),
													 'color' => "#743A3A",
													  ),
		                           'OrderSn'=> array('value' => urlencode($OrderSn),
													 'color' => "#743A3A",
													  ),
								  
								  'OrderStatus'=> array('value' => urlencode($OrderStatus),
													 'color' => "#C4C400",
													  ),
								 
								  'remark'=> array('value' => urlencode($remark),
													 'color' => "#C4C400",
													  ),

                                  )
                  );
		$tree = urldecode(json_encode( $data ));
		$info = M ( 'member_public' )->find ();
		$url_get = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $info ['appid'] . '&secret=' . $info ['secret'];	
		$ch1 = curl_init ();
		$timeout = 5;
		curl_setopt ( $ch1, CURLOPT_URL, $url_get );
		curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
		$accesstxt = curl_exec ( $ch1 );
		curl_close ( $ch1 );
		$access = json_decode ( $accesstxt, true );//取得access_token
		if (empty ( $access ['access_token'] )) {
			$msg="获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试";
			addWeixinLog ( "access_token通知：" .  var_export($msg, true )  );
			//$this->error ( '获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试。' );
		}
		
		//需要提交的url	
		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access ['access_token'];
		$header [] = "content-type: application/x-www-form-urlencoded; charset=UTF-8";		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $tree);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$res = curl_exec ( $ch );
		curl_close ( $ch );
		$res = json_decode ( $res, true );  
		addWeixinLog ( "订单模板信息：" .  var_export($res, true )  );
		if ($res ['errcode'] == 0) {
			return  '发送成功' ;
         return 0;
		} else {
			//$this->success ( '发送失败，错误的返回码是：' . $res ['errcode'] . ', 错误的提示是：' . $res ['errmsg'] );
           return $res ['errcode'];
		}
	}
	// 发送模板消息-返现到账通知
function sendTpl($openid,$price,$username) {    
	$UcenterMember=M("UcenterMember"); 
	  $map["openid"]=$openid;
      $info=$UcenterMember->where($map)->find(); 
	$order=time().rand(10,10000);
	$title="尊敬的客户您好，"."返现已充入您的现金帐户！";
	$data = array('touser' => $openid,
                  'template_id' =>"5JUCAR21KBvPSy45Yquoow9hKsDoYgfVkVlvzMqYoAs",
				  'url' => $url,
				  'topcolor' => "#7B68EE",
                  'data' => array('first'	=> array('value' => urlencode($title),
													 'color' => "#743A3A",
													  ),
		                         'order'	=> array('value' => urlencode($order),
													 'color' => "#743A3A",
													  ),
								  
								  'money' 	=> array('value' => urlencode($price),
													 'color' => "#C4C400",
													  ),
								 'remark' 	=> array('value' => urlencode($title),
													 'color' => "#C4C400",
													  ),

                                  )
                  );
		$tree = urldecode(json_encode( $data ));
		$info = M ( 'member_public' )->find ();
		$url_get = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $info ['appid'] . '&secret=' . $info ['secret'];	
		$ch1 = curl_init ();
		$timeout = 5;
		curl_setopt ( $ch1, CURLOPT_URL, $url_get );
		curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
		$accesstxt = curl_exec ( $ch1 );
		curl_close ( $ch1 );
		$access = json_decode ( $accesstxt, true );//取得access_token
		if (empty ( $access ['access_token'] )) {
			$this->error ( '获取access_token失败,请确认AppId和Secret配置是否正确,然后再重试。' );
		}
		
		//需要提交的url	
		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access ['access_token'];
		$header [] = "content-type: application/x-www-form-urlencoded; charset=UTF-8";		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $tree);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$res = curl_exec ( $ch );
		curl_close ( $ch );
		$res = json_decode ( $res, true );
		if ($res ['errcode'] == 0) {
			//$this->success ( '发送成功' );
         return "返利成功";
		} else {
			//$this->success ( '发送失败，错误的返回码是：' . $res ['errcode'] . ', 错误的提示是：' . $res ['errmsg'] );
        return $res ['errcode'];
		}
	}	