<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\common\model;
use think\Controller;
use think\Db;
use think\Model;
/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class User extends Model {

	/* 手机号注册页面 */
	public function register($password = '',$mobile = '', $email = '', $verify = ''){
		
		if(!C("USER_ALLOW_REGISTER")){
            $this->error="注册已关闭";return false;
        }
		if($_POST){ //注册用户
            /* 检测验证码 */
			 
		if(input("post.type")){
			/* 检测验证码 */
                $verify=$_POST["verify"];
				if(!$verify){
			    $this->error="验证码不能为空！";
		        return false;
		      }
			    if(!captcha_check($verify)){
				   $this->error="验证码输入错误！";  
				   return false;
			   }
			}
             $username =safe_replace($_POST["username"]);//过滤
			 if(!$username){
			    $this->error="用户名不能为空！"; return false;
			 }
			 if(strlen($username)<6) {
             $this->error="用户名必须包含至少含有6个字符！";
                 return FALSE;
             } 
			 if(strlen($username)>25) {
             $this->error="用户名超过25个字符！";
                 return FALSE;
             }
			 
           
			 if(isset($_POST["mobile"])){ 
                 $mobile =safe_replace($_POST["mobile"]);//过滤
				 if(!preg_match("/1[34578]{1}\d{9}$/",$mobile)){
			  	      $this->error="手机号格式不正确！"; return false;
			      }	
			     $data["mobile"]=$mobile;
			 }
			    
          
             $password =safe_replace($_POST["password"]);//过滤
			 if(!$password){
			    $this->error="密码不能为空！"; return false;
			 }
			 if(strlen($password)<6) {
             $this->error="密码必须包含至少含有6个字符！";
                 return FALSE;
             } 
			 $repassword =input("repassword");//过滤
			 if($repassword){ 
			    $repassword =safe_replace($_POST["repassword"]);//过滤
			 }
			 if($repassword!==$password) {
                 $this->error="密码与确认密码不符合！";
                 return FALSE;
                 
			 } 
			 $email =input("email");//过滤
			 if(isset($email)){
				
				 if(input("email")&&!$email){
					$this->error="邮箱不能为空！"; return false;
				 }
				 if(!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email)){
					$this->error="邮箱格式不正确！"; return false;
				  }
			 }
			
            $key=config('database.key');
            $data['password']=ucenter_md5($password,$key);
		    $data["username"]=$username;
			$data['email']=$email;
			$data['status']=1;
		    //分销
			if(session('linkid')){
			   $data['pid']=session('linkid');
			}
			$data["reg_time"]=time();
			$uid=db('UcenterMember')->insertGetId($data);
             $this->send($uid);
			
			return true;
       }
	}
		/* 手机号注册页面 */
	public function reg($password = '',$mobile = '', $email = '', $verify = ''){
		
		if(!C("USER_ALLOW_REGISTER")){
            $this->error="注册已关闭";return false;
        }
		if($_POST){ //注册用户
            /* 检测验证码 */
			 
		if(input("post.type")){
			/* 检测验证码 */
                $verify=$_POST["verify"];
				if(!$verify){
			    $this->error="验证码不能为空！";
		        return false;
		      }
			    if(!captcha_check($verify)){
				   $this->error="验证码输入错误！";  
				   return false;
			   }
			}
             $username =safe_replace($_POST["username"]);//过滤
			 if(!$username){
			    $this->error="用户名不能为空！"; return false;
			 }
			 if(strlen($username)<6) {
             $this->error="用户名必须包含至少含有6个字符！";
                 return FALSE;
             } 
			 if(strlen($username)>25) {
             $this->error="用户名超过25个字符！";
                 return FALSE;
             }
			 
           
			 if(isset($_POST["mobile"])){ 
                 $mobile =safe_replace($_POST["mobile"]);//过滤
				 if(!preg_match("/1[34578]{1}\d{9}$/",$mobile)){
			  	      $this->error="手机号格式不正确！"; return false;
			      }	
			     $data["mobile"]=$mobile;
			 }
			    
          
             $password =safe_replace($_POST["password"]);//过滤
			 if(!$password){
			    $this->error="密码不能为空！"; return false;
			 }
			 if(strlen($password)<6) {
             $this->error="密码必须包含至少含有6个字符！";
                 return FALSE;
             }  
			
			 $email =input("email");//过滤
			 if(isset($email)){
				
				 if(input("email")&&!$email){
					$this->error="邮箱不能为空！"; return false;
				 }
				 if(!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email)){
					$this->error="邮箱格式不正确！"; return false;
				  }
			 }
			
            $key=config('database.key');
            $data['password']=ucenter_md5($password,$key);
		    $data["username"]=$username;
			$data['email']=$email;
			$data['status']=1;
		    //分销
			if(session('linkid')){
			   $data['pid']=session('linkid');
			}
			$data["reg_time"]=time();
			$uid=db('UcenterMember')->insertGetId($data);
             $this->send($uid);
			
			return true;
       }
	}
	
	 public function send($uid){
        /* 检测是否在当前应用注册 */
        $map['id'] =(int)$uid;
        $info =Db::name("ucenterMember")->where($map)->find();
        if(!$info){ //未注册
            $this->error="用户不存在！";
		    return false;
		}
        /* 登录用户 */
        $auth = array(
            "uid"             => $uid,
            "username"        => $info["username"],
            "last_login_time" => $info["last_login_time"],
        );
        session("user_auth", $auth);
        session("uid", $auth["uid"]);
        session("user_auth_sign", data_auth_sign($auth));
     /* 登录购物车处理函数 */
        $cart=session('cart');
	    if($cart){
			foreach ($cart as $key=>$val) {
			    $id=$val['id'];
				if(isset($_SESSION['cart'][$id])) {
			          //$_SESSION['cart'][$id]['num'] += $num;
		        }
			    $item['num'] =$cart[$id]['num'];
				$item["sku_id"]=$id;
                $item['num'] =$cart[$id]['num'];
			    $item['goods_id'] = $cart[$id]['goodsid'];
			    $item['price'] =$cart[$id]['price'];
			    $item['path'] =$cart[$id]['path'];
				$item['uid'] = $uid;
			    $item['specifications'] =$cart[$id]['specifications'];
				$num=$cart[$id]['num'];
			    $data['goods_id']= $cart[$id]['goodsid'];//商品id
			    $data['sku_id']=$id;//库存id
			    $data['uid']=$uid;//用户id
			    $list=Db::name("cart")->where($data)->find();
			   if($list){
				   $save['num']=$list["num"]+$num;
				   $cart[$id]['num']=$save['num'];
				   Db::name("cart")->where($data)->update($save);
			}
			else{
			      Db::name("cart")->insert($item);
			}
		   }
		} 
     
        return true;
    }

	/* 登录页面 */
	public function login(){
		
				 
		if(input("post.type")){
			/* 检测验证码 */
                $verify=$_POST["verify"];
				if(!$verify){
			    $this->error="验证码不能为空！";
		        return false;
		      }
			    if(!captcha_check($verify)){
				   $this->error="验证码输入错误！";  
				   return false;
			   }
			}

            $mobile=$_POST["mobile"];
			if(!$mobile){
			    $this->error="账户不能为空！";
		        return false;
		      }
          
			  $username =safe_replace($mobile);//过滤
			  if($this->checkemail($mobile)){
			  	$map["email"]=$username;
			  }
			  else if($this->checkmobile($mobile)){
			  	$map["mobile"]=$username;
			  }
			  else{
			  	$map["username"]=$username;
			  }
              $user =db('UcenterMember')->where($map)->find();
              if(!$user){
			    $this->error="用户不存在！";
		        return false;
		      }
			   $password=$_POST["password"];
			  $key=config('database.key');
			 /* 调用UC登录接口登录 */
			 $map["password"]=ucenter_md5($password, $key);
			 $user =db('UcenterMember')->where($map)->find();
			 if(!$user){
			    $this->error="密码错误！".$map["password"];
		        return false;
		      }
		   /* 获取用户数据 */
		    $user =db('UcenterMember')->where($map)->find();
	        if($user['status']){
			      $uid = $user["id"];
				   if(input('post.remember')){ 
					     cookie('username',$username,2592000); // 指定cookie保存30天时间
					     cookie('password',$password,2592000); // 指定cookie保存30天时间		 
				  }
		  }else{
		    $this->error="用户被禁用！";
		    return false;
		  }
	      $this->send($uid);
		  return true;	
	}
    /**
    * 验证手机号是否正确
    * @author 范鸿飞
    * @param INT $mobile
    */
    function checkemail($email) {
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        return preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email) ? true : false;
    }
    /**
    * 验证邮箱是否正确
    * @author 
    * @param INT $mobile
    */
    function checkmobile($mobile) {
       if(preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
            return true;
         }else{  
              return false;
          } 
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
	}
