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
namespace app\common\model;
use think\Model;

class Fenxiao extends Model{

    public function  img(){
        //属性
		 $uid=is_login();
		   $url=input('link');
		   if(strpos($url,"http")!=false){
		       $url=$url;
	       }else if(strpos($url,"https")!==false){
		       $url=$url;
	          }
           $url=$url."?linkid=".$uid;
		   $UcenterMember=db("UcenterMember")->find($uid);
		
          
            $url= qrcode($url,$UcenterMember["cover_id"],$uid);
		return  $url;
    }
    public  function createurl(){
        
		   $uid=is_login();
		   $url=input('link');
		   if(strpos($url,"http")!=false){
		       $url=$url;
	       }else if(strpos($url,"https")!==false){
		       $url=$url;
	          }
           $url=$url."?linkid=".$uid;
		  return $url;
         
   }
  public  function user(){
        
		   $uid=is_login();
		   $url=input('link');
		   if(strpos($url,"http")!=false){
		       $url=$link;
	       }else if(strpos($url,"https")!==false){
		       $url=$link;
	          }
           $url=$url."?linkid=".$uid;
		  return $url;
         
   }

}
