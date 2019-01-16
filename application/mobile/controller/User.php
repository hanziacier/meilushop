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
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class User extends Home {

	/* 用户中心首页 */
	public function index(){
		
	}
  	/* 注册页面 */
	/* 注册页面 */
	public function register($mobile = "", $password = "", $repassword = "", $email = "", $verify = ""){
	
		if($_POST){ //注册用户
		
            $user=new \app\common\model\User; 
			
		    $res=$user->reg();
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

	
	/* 验证码，用于登录和注册 */
	public function verify(){
		$Verify =     new \think\Verify();  
        $Verify->fontSize = 30;
		$Verify->length   = 4;
        $Verify->entry(1);
	}
	/* 登录页面 */
	public function login($mobile= "", $password= "", $verify = ""){
		$mobile =safe_replace($mobile);//过滤
		if($_POST){
		    $user=new \app\common\model\User; 
		    $res=$user->login($mobile, $password);
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
    /**
    * 验证手机号是否正确
    * @param INT $mobile
    */
    function checkemail($email) {
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        return preg_match($pattern, $email) ? true : false;
    }
    /**
    * 验证邮箱是否正确
    * @author 
    * @param INT $mobile
    */
    function checkmobile($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }
	/* 退出登录 */
	  /* 退出登录 */
    public function logout(){
        if(is_login()){
           session("user_auth", null);
           session("user_auth_sign", null);
		   cookie('password',null);
		   cookie('username',null);
            session('[destroy]');
            $this->success('退出成功！',url('index/index'));
        } else {
            $this->redirect('login');
        }
    }

    public function password(){
	    	if($_POST){ //注册用户
			/* 检测验证码 */
				  $uid        =   is_login();
                  $map["username"]  =  safe_replace( input("post.username"));
				  $email=safe_replace(input("post.email"));
                  $map["email"] =safe_replace(input("post.email"));
				  $res = db('UcenterMember')->where($map)->find();
				  
				  if(!$res){
						$this->error("用户不存在！");
				  }
				  $time =  date("Y-m-d h:i",time());//时间
				  $url = 'http://api.sendcloud.net/apiv2/mail/send';
				  $API_USER = C("API_USER");
				  $API_KEY = C("API_KEY");
				  $hash=$this->ordersn();
				  $url=root_url().url('user/update',array("id"=>$res["id"],"hash"=>$hash));
                  $html="您在".$time."向".C('SITE_NAME')."申请通过邮箱找回密码，如若非本人操作请忽略本邮件！
						请通过点击以下链接进行密码重置：<a href='".$url."' style='color: #03c5ff; text-decoration:
                        underline;' target='_blank'>".$url."</a>
						(如果不能打开页面，请复制该地址到浏览器打开)";
                   $data["content"]=$html;
				   $data["to"]=$email;
				   $data["uid"]=$res["id"];
				   $data["api_user"]=$API_USER;
				   $data["create_time"]=$time;
				   $data["hash"]=$hash;
				   $data["title"]="找回密码";
				   db("email")->insert($email);



				  //您需要登录SendCloud创建API_USER，使用API_USER和API_KEY才可以进行邮件的发送。
				  $param = array(
					  'apiUser' => $API_USER,
					  'apiKey' => $API_KEY,
					  'from' => 'service@sendcloud.im',
					  'fromName' => '找回密码',
					  'to' => $email,
					  'subject' => '来自'.C('SITE_NAME').'的邮件！',
					  'html' => $html,
					  'respEmailId' => 'true');

				$data = http_build_query($param);

				$options = array(
					  'http' => array(
					  'method'  => 'POST',
					  'header'  => 'Content-Type: application/x-www-form-urlencoded',
					  'content' => $data
				));

				$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);
                $result=json_encode($result);
				if($result){
						$this->success("发送成功！");
				 }else{
				    $this->success("发送失败！");
				 }

                  		
		}else{
			
			$this->meta_title = '忘记密码';
             return $this->fetch( );		
		}
	}
	 public function ordersn(){
		$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'input', 'J');
		$orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%04d%02d', rand(1000, 9999),rand(0,99));
		return $orderSn;
	}
   public function sendSms(){
       $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
	   $mobile =I('phone',0,'intval');
	   $send_code =I('send_code',0,'intval');//安全校验码
	   $mobile_code = random(4,1);//验证码
	   if(empty($mobile)){
		   exit('手机号码不能为空');
	   }
       // $map['mobile'] =$mobile;
       if(M('UcenterMember')->where($map)->find()){
			//exit('该手机号已注册');
	   }
	   $safecode=session('send_code');
	   if(empty($safecode) or $send_code!=$safecode){
			//防用户恶意请求
			exit('请求超时，请刷新页面后重试');
		}
		$post_data = "account=".C('SMSACCOUNT')."&password=".C('SMSPASSWORD')."&mobile=".$mobile."&content=".rawurlencode($mobile_code);//密码可以使用明文密码或使用32位MD5加密
		//密码可以使用明文密码或使用32位MD5加密
		$gets =  xml_to_array(Post($post_data, $target));
	    if($gets['SubmitResult']['code']==2){
			$_SESSION['mobile'] = $mobile;
			$_SESSION['mobile_code'] = $mobile_code;
	    }
	    $data['status']=1;
	    $data['ret']=$gets['SubmitResult']['msg'];
	    $this->ajaxReturn($data);
	}
    /**
     * 修改密码提交
     */
    public function modify(){
		if ( !is_login() ) {
			$this->error( "您还没有登陆",U("User/login") );
		}
        if ($_POST) {
            //获取参数
            $uid        =   is_login();
            $password   =  safe_replace( input("post.old"));
            $repassword =safe_replace(input("post.repassword"));
            $data["password"] = safe_replace(input("post.password"));
            
            empty($password) && $this->error("请输入原密码");
            $password   =  md5(sha1( input("post.old")).config('database.key'));
            $where["password"] = $password;
			$where["id"] = $uid;
            $res = db('UcenterMember')->where($where)->find();
            if(!$res){
                $this->error("原密码错误！");
            }

            empty($data["password"]) && $this->error("请输入新密码");
            empty($repassword) && $this->error("请输入确认密码");
            if($data["password"] !== $repassword){
                $this->error("您输入的新密码与确认密码不一致");
            }
			$map["id"]=$uid;
            $data['password']=md5(sha1($repassword).config('database.key'));
            $res = db('UcenterMember')->where($map)->field('password')->update($data);
            if($res){
                $this->success("修改密码成功！");
            }else{
                $this->error("修改失败");
            }
        }else{    
			$this->meta_title = '修改密码';
             return $this->fetch( );
        }
    }
	 /**
     * 修改密码提交
     */
    public function update(){
		
        if ($_POST) {
            //获取参数
         
            $uid   = session("uid");
           
            $password= safe_replace(input("post.password"));
            $repassword =safe_replace(input("post.repassword"));
            empty($password) && $this->error("请输入密码");
            empty($repassword) && $this->error("请输入确认密码");
            if($password !== $repassword){
                $this->error("您输入的新密码与确认密码不一致");
            }
			$map["id"]=$uid;
            $data['password']=md5(sha1($password).config('database.key'));
            $res = db('UcenterMember')->where($map)->field('password')->update($data);
            if($res){
                $this->success("重置成功！");
            }else{
                $this->error("重置失败");
            }
        }else{  
		    $uid   =  safe_replace( input("id"));
            $hash =safe_replace(input("hash"));
			$where["hash"] = $hash;
			$where["uid"] = $uid;
            $info = db('email')->where($where)->find();
            if(!$info){
                $this->error("邮件不存在！");
            }
			$this->meta_title = '重置密码';
			session("uid",$info["uid"]);
            return $this->fetch( );
        }
    }
 
}
