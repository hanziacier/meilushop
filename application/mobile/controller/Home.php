<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\mobile\controller;
use think\Controller;
use think\Db;
/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class Home extends Controller {

	/* 空操作，用于输出404页面 */

    protected function initialize(){
        /* 读取站点配置 */
       
         
          //session('theme_color','#09c762');
      
        if(session('cart'))
		 {$cartlist=session('cart');
		}else{$cartlist=array();}
		$sum = 0;$price = 0.00;
		if($cartlist){
		    foreach ($cartlist as $item) {		
		         $sum += $item['num'];
				 $price += $item['num'] * $item['price'];
		    }
		}	/**购物车调用**/
		if( is_login( ) ){
			$uid=is_login();
		    $UcenterMember=db("UcenterMember")->find($uid);
            $this->assign( 'UcenterMember',$UcenterMember );
			
		
		} 
		
	    session("color",null);
        if(input('color') ){
			$color="#".input('color');
			session("color",$color); 
	   } 
	   if(session("color")){
	      $config['theme_color']=session("color");
	   }else{
	        //$config["theme_color"]="#F8515B";
		   //$config['theme_color']='#09c762';
		   //$config["theme_color"]="#0e90d2";//blue
		   //$config['theme_color']='#F37B1D';//yellow
		   //$config['theme_color']='#5eb95e';//yellow
		   // $config['theme_color']='#00aa88';//yellow
			 //$config['theme_color']='#f92e5e';//yellow
			//$config['theme_color']='#60b49d';//yellow
	       $config['theme_color']='#ee394a';//red
 $config['theme_color']=C('MOBILE-COLOR');//red
	   }
       $this->assign ( 'config',$config );
	   $this->assign( 'cartlist',$cartlist );
	   $cart["total_num"]=$sum;
	   $cart["total_money"]=$price;
	   $cart["total_count"]=count($cartlist);
       $this->assign( 'cart',$cart);

	   $array["uid"]=is_login()?is_login():0;
		   $recent=db("keyword")->where($array)->select();
           $this->assign ( 'recent',$recent );
		
		$map["status"]=1;
		$slist=db("keyword")->where($map)->order("id desc")->select();
        $this->assign ( 'slist',$slist ); 
    }


}
