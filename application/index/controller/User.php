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
use think\Db;
use think\Session;
use think\Request;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class User extends Home {

	/* 注册页面 */
	public function register($mobile = "", $password = "", $repassword = "", $email = "", $verify = ""){
	
		if($_POST){ //注册用户
		
            $user=new \app\common\model\User; 
			
		    $res=$user->register();
			if($res){
				  $url= session("url")?session("url"):url('index/index');
			      $this->success("注册成功",$url);
			}else{
			   $this->error($user->getError());
			}

		} 
		else { 	
			
	      $meta_title = '会员注册'; 
		  session("url",null);
		  $url=input('server.HTTP_REFERER');
          session("url",$url);
		  $this->assign('meta_title',$meta_title);
		  return $this->fetch();
		}
	}
    	

	/* 登录页面 */
	public function login(){
		
		if($_POST){ 
			
		    $user=new \app\common\model\User; 
		    $res=$user->login();
			if($res){
				  $url= session("url")?session("url"):url('index/index');
			      $this->success("登录成功",$url);
			}else{
			   $this->error($user->getError());
			}

		}else {
             if(is_login()){
			   $this->redirect("index/index");
		     }
             session("url",null);
		     $url=input('server.HTTP_REFERER');
             session("url",$url);
		     $this->meta_title = '登录';	
			//显示登录表单
			 return $this->fetch();
		}
	}
  

    public function forget($username = "", $password = ""){
		
		    session("send_code",$this->random());
			$this->assign('code',session("send_code"));
			return $this->fetch();
		
	}

	/* 退出登录 */
	public function logout(){
		if(is_login()){
			$Member =model("Member");
			$Member->logout();
			$this->redirect("index/index");
		} else {
			$this->redirect("User/login");
		}
	}



	
  public   function Post($curlPost,$url){
	    $url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
}

public  function random($length = 6 , $numeric = 0) {
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	if($numeric) {
		$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	} else {
		$hash = '';
		$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
	}
	return $hash;
}
//发送验证码
public function sendSms($length = 6 , $numeric = 0,$verify="") {
	if(!check_verify($verify)){
		//$this->error("验证码输入错误！");
	}
	$mobile = $_POST['mobile'];
    $map["mobile"]=safe_replace($mobile);
	$info=db("UcenterMember")->where($map)->find();	
	if(!$info){
		//防用户恶意请求
		$this->error('系统未检测到该手机号');
	}
	$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
	
	$send_code = $_POST['send_code'];
	$mobile_code =$this-> random(4,1);
	if(empty($mobile)){
		$this->error('手机号码不能为空');
	}
	if(!session('send_code')||$send_code!=session('send_code')){
		//防用户恶意请求
		$this->error('请求超时，请刷新页面后重试');
	}
    $u=C('HUYIUSERNAME');
	$p=C('HUYIPASSWORD');
	$post_data = "account={$u}&password={$p}&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");

	//密码可以使用明文密码或使用32位MD5加密
	$gets = $this->xml_to_array($this->Post($post_data, $target));
	if($gets['SubmitResult']['code']==2){
		$_SESSION['mobile'] = $mobile;
		$_SESSION['mobile_code'] = $mobile_code;
		$this->success($gets['SubmitResult']['msg']);
	}else{
	    $this->error($gets['SubmitResult']['msg']);
	}

}
public function confirm($mobile = '', $verify = ''){
		
		if(Request::instance()->isPost()){ //注册用户
			/* 检测验证码 */
			if(($mobile!==$_SESSION['mobile'])&&($verify!==$_SESSION['mobile_code'])){
				$this->error("动态码输入错误！");
			} 
			else{
                $this->success("验证成功！");
            }
			
		}
	}
	public function findpassword($mobile = '', $send_code = ''){
		if(is_login()){
			$this->redirect("index/index");
		}
        
		if(Request::instance()->isPost()){ //注册用户
			/* 检测验证码 */
			if(($mobile!==$_SESSION['mobile'])&&($verify!==$_SESSION['mobile_code'])){
				$this->error("验证码输入错误！");
			} 
			
           $repassword = input("post.repassword");
           $data["password"] = input("post.password");
           empty($data["password"]) && $this->error("请输入新密码");
           empty($repassword) && $this->error("请输入确认密码");

            if($data["password"] !== $repassword){
               $this->error("您输入的新密码与确认密码不一致");
            }

            $data_auth_key=config("database.key");
			$map['mobile']=safe_replace($mobile);
            $data['password']=md5(sha1($repassword).$data_auth_key);
            $res =db('UcenterMember')->where($map)->field("password")->update($data);
            if($res){
                $this->success("修改密码成功！","User/login");
            }else{
                $this->error("修改失败！");
            }
			
		}
	}

	public function update($mobile = '', $send_code = ''){
		if(is_login()){
			$this->redirect("index/index");
		}
        
		if(Request::instance()->isPost()){ //注册用户
			/* 检测验证码 */
			if(($mobile!==$_SESSION['mobile'])&&($verify!==$_SESSION['mobile_code'])){
				$this->error("验证码输入错误！");
			} 
			$uid = is_login();
  
            //$repassword = I("post.repassword");
           // $data["password"] = I("post.password");
            //empty($data["password"]) && $this->error("请输入新密码");
           // empty($repassword) && $this->error("请输入确认密码");

            if($data["password"] !== $repassword){
               $this->error("您输入的新密码与确认密码不一致");
            }

            $data_auth_key=config("database.key");
			$map['id']=is_login();
            $data['password']=md5(sha1($repassword).$data_auth_key);
            $res =db('UcenterMember')->where($map)->update($data);
            if($res){
                $this->success("修改密码成功！");
            }else{
                $this->error("修改失败！");
            }
			
		}
	}
public function xml_to_array($xml){
	$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
	if(preg_match_all($reg, $xml, $matches)){
		$count = count($matches[0]);
		for($i = 0; $i < $count; $i++){
		$subxml= $matches[2][$i];
		$key = $matches[1][$i];
			if(preg_match( $reg, $subxml )){
				$arr[$key] = $this->xml_to_array( $subxml );
			}else{
				$arr[$key] = $subxml;
			}
		}
	}
	return $arr;
}
    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function profile(){
		if ( !is_login() ) {
			$this->error( "您还没有登陆",U("User/login") );
		}
        if (Request::instance()->isPost()) {
            //获取参数
            $uid = is_login();
            $password   =   input("post.old");
            $repassword = input("post.repassword");
            $data["password"] = input("post.password");
            empty($password) && $this->error("请输入原密码");
            empty($data["password"]) && $this->error("请输入新密码");
            empty($repassword) && $this->error("请输入确认密码");
            if($data["password"] !== $repassword){
                $this->error("您输入的新密码与确认密码不一致");
            }
            $data_auth_key=config("database.key");
			$map['id']=is_login();
            $data['password']=md5(sha1($repassword).$data_auth_key);
			$res =db('UcenterMember')->where($map)->update($data);
            if($res){
                $this->success("修改密码成功！");
            }else{
                $this->error($res["info"]);
            }
        }else{    
		     $this->meta_title = '修改密码';
			 $this->assign('meta_title', $this->meta_title);
             return $this->fetch();
        }
    }

}
