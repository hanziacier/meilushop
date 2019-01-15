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
namespace app\index\controller;
use think\Controller;

class Home  extends Controller
{
	
	 protected function initialize(){
        /* 读取站点配置 */
       
        if(!C('WEB_SITE_CLOSE')){
           $this->error('站点已经关闭，请稍后访问~');
        }
	    //$this->error("站点已关闭");
		$category=model("category")->getCategory() ;
		$this->assign('category', $category);
	     //session('cart',null);
		//dump(session('cart'));
		if(session('cart'))
		 {$cartlist=session('cart');
		}else{$cartlist=array();}
		/**购物车调用**/
		$sum = 0;$price = 0.00;
		if($cartlist){
		    foreach ($cartlist as $item) {		
		         $sum += $item['num'];
				 $price += $item['num'] * $item['price'];
		    }
		}	
		if( is_login( ) ){
			$uid=is_login();
		    $UcenterMember=db("UcenterMember")->find($uid);
		
            $this->assign( 'UcenterMember',$UcenterMember );
			 $map["uid"]=$uid;
        $c=db("collect")->where($map)->select();
		if($c){
			foreach ($c as &$v) {
                $v['image']= get_goods_cover($v["goods_id"]); 
				$v['price']= get_goods($v["goods_id"],'price');
             }
		  $this->assign( 'c' ,$c);
		}
		
		}
		if(input('linkid')){
		  $linkid=input('linkid');
		  session('link',$linkid);
		}
        $controller=request()->controller();
		$action=request()->action();	
	
		$current_url=strtolower($controller."/".$action);
		$this->assign ( 'current_url',$current_url);
		$this->assign ( 'action',$current_url);
        if($current_url=="order/index"||$current_url=="order/pay"){
	       $this->assign ( 'showsidebar',true);
	   }

	   $this->assign( 'cartlist',$cartlist );
	   $cart["total_num"]=$sum;
	   $cart["total_money"]=$price;
	   $cart["total_count"]=count($cartlist);
       $this->assign( 'cart',$cart);
	   $channel=model("channel")->getList();
	   $this->assign( 'channel',$channel);
	    $data ['ip'] =$_SERVER['REMOTE_ADDR'];;
	
		$history=db("history")->where($data)->select();
		if($history){
			foreach ($history as &$v) {
                $v['image']= get_goods_cover($v["goods_id"]); 
				$v['price']= get_goods($v["goods_id"],'price');
             }
		   $historynum=db("history")->where($data)->count();
           $this->assign( 'historynum' ,$historynum);
		  $this->assign( 'history' ,$history);
		}
       
        /* 热门搜索 */
		$str=db( 'config' )->where( 'name="REKEWORD"' )->find();	
		$hotsearch=explode("|",$str['value']);
		$this->assign( 'hotsearch' , $hotsearch );

	    $footer=model("category")->getfooter() ;
	    $this->assign( 'footer',$footer );
        $systems=array();
	    if(C('pin')){
           $systems["pin"]=1;

	    }
         if(C('fenxiao')){
           $systems["fenxiao"]=1;

	    }
		$this->assign( 'systems' , $systems);

    }

 
}