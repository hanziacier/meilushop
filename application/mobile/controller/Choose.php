<?php
namespace app\mobile\controller;
use think\Controller;
use think\Db;                  
class Choose extends Home{
		/**首页**/


   /* 地址列表 */
	public function lists(){
	    if(!is_login()) {
		    $this->redirect("User/login");
		}
		session("order_id",safe_replace(input('id'))); 			
		$uid=is_login();
        $map['uid']=$uid;
		$this->meta_title = '地址管理';
		$p= input('p')?input('p'):1;
	    $res=apiLists('address',$map,"10",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				   $vo['edit_url'] = url('edit?id='.$vo['id']);
				   $vo['del_url'] = url('del?id='.$vo['id']);
				   $vo["html"]='<li>
					<div class="shdz_con01_main">
						<div class="shdz_con01_t">
							<div class="shdz_con01_tl fl">
								<label class="radio"><input type="radio" onclick="choose('.$vo['id'].')" value="'.$vo['id'].'"/> <i class="icon-radio"></i>
            </label>选择地址
							</div>
							<div class="shdz_con01_tr fr">
								<a href="'.$vo['edit_url'].'" class="shdz_con01_bj">编辑</a>
								<a href="'.$vo['del_url'].'" class="shdz_con01_sc">删除</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="shdz_con01_m">
							<h1>'.$vo['username'].' <span>'.$vo['mobile'].'</span></h1>
							<h2>'.$vo['province'].$vo['city'].$vo['area'].$vo['address'].'</h2>
						</div>
					</div>
				</li>';}
				
		}
	    if(!$_POST){/**大家都在买,推荐位**/
		   $this->assign('list',$data);// 赋值数据集
           $this->assign('maxnum',$res['pagenum']);// 赋值数据集
           return $this->fetch( );
        }else{
		 
		 //AJAX刷新数据
           return $data;  
        }
	}
    public  function update() {
		
		if ( !is_login() ) {
			$this->error( "您还没有登陆",U("User/login") );
		} 
	
		$status=input("status");
		$uid=is_login();	
	    $map['uid']=$uid;//用户id
	      $data=array();
            foreach($_POST as $key=>$val){
		      $data[$key]=safe_replace($val);
		    }
        if($_POST){ //提交表单
		    $Address = new \app\wap\model\Address;
		     $res=$Address->allowField(true)->validate(true)->save($data);
			 $id= $Address->getLastInsID();
             if($id){
				$data["code"]=1;
				$data["id"]=$id;
				return $data;
				
            } else {
                $error = $Address->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } 
	}
   public function edit($id=""){
	   if ( !is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}    
	   if(!($id && is_numeric($id))){
		       $this->error('ID错误！');
		 }
		if($_POST){
		   $Ad = model("address");
		   $data=array();
            foreach($_POST as $key=>$val){
		       $data[$key]=safe_replace($val);
		    }
           $res=$Ad->validate(true)->allowField(true)->save($data,['id' => $_POST['id']]);
	       if($res){
			    addUserLog("edit_ad",is_login());
		        $this->success("更新成功！",cookie("__forward__"));
		   }else{
			    $error=$Ad->getError();
			    $this->error($error?$error:"更新失败！");
		   } 
	  }
	  else{
		 $map['id']=$id;$uid=is_login();	
	    $map['uid']=$uid;//用户id
		 $info=db("Address")->where($map)->find();
	     $this->assign('info', $info);
		 if(!$info){
			   $this->error( "无对应的地址" );
		  }cookie("__forward__",input('server.HTTP_REFERER'));
		  $where["pid"]=0;
		  $arealist=db("area")->where($where)->select(); 
		  $this->assign('arealist', $arealist);
		  $this->meta_title="编辑地址";
		  $this->assign('meta_title', $this->meta_title);
	      return $this->fetch("add");
	   }
	}

    public  function change($pid = 0){

		   $pid=input('pid'); 	
           if(!($pid && is_numeric($pid))){
		       $this->error('数据类型错误！');
		   }
		   $map["pid"]=$pid;
		   $list=db("area")->where($map)->select();
		   return $list?$list:""; 
   }
   public  function del() {
		
		if ( !is_login() ) {
		$this->error( "您还没有登陆",url("User/login") );
		} 
		$id=input("id");
		if(!($id && is_numeric($id))){
		   $this->error('用户ID错误！');
		}
		$uid=is_login(); 
		$map["uid"]=$uid;	
		$map["id"]=$id;	
		$info= db("address")->where($map)->find(); 
		if(!$info){
		   $this->error( "地址不存在" );
		}
		$res=db("address")->where($map)->delete();
		if($res){
			$url=url("lists");
			$this->success("删除成功",$url);
		}
		else{ 
			
			$this->error("删除失败");
		}
   }
     public function add($id=""){
		if ( !is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}    

		if($_POST){
		   $Address = model("address");
		   $data=array();
			foreach($_POST as $key=>$val){
			   $data[$key]=safe_replace($val);
			}
		   $res= $Address->validate(true)->allowField(true)->save($data);
		   $id= $Address->getLastInsID();
             if($id){
				$data["code"]=1;
				$data["id"]=$id;
				return $data;
				
            } else {
                $error = $Address->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
		}
		else{
          session("order_id",$id);  
		  $where["pid"]=0;
		  cookie("__forward__",input('server.HTTP_REFERER'));
		  $arealist=db("area")->where($where)->select(); 
		  $this->assign('arealist', $arealist);
		  $this->meta_title="新增地址";
		  $this->assign('meta_title', $this->meta_title);
		  return $this->fetch("add");
		}
	}

  public function coupon(){
	    if(!is_login()) {
			 $this->redirect("User/login" );
		}
        $uid=is_login();	
        /*变量支付方式*/
        $paytype=input("paytype");
	    $this->assign('paytype',$paytype);
		/*变量运输方式*/
        $shippingway=input("shippingway");
        $this->assign('shippingway',$shippingway);
		/*变量支付订单号*/
        $tag=input("tag");
		$this->assign('tag',$tag);
       /*变量地址id*/
        $addressid=input("addressid");
        $this->assign('addressid',$addressid);
		/*变量发票类型*/
		$intype=input("intype");   		
        $this->assign('intype',$intype);
		/*变量发票内容*/
        $incontent=input("incontent");	
	    $this->assign('incontent',$incontent);	
         /*变量发票单位*/
        $incontent=input("company");	
	    $this->assign('company',$company);

       $uid=is_login();
		/* 优惠券未使用*/
		$map['uid']=$uid;
		$map['status']=1;
        $map['end_time']=array('gt',time());
		$list=M("UserCoupon")->where($map)->select();
		$this->assign('list', $list);
		$this->meta_title = '优惠券';
		$this->display();
     }
     public function goods_lists(){
         if(!is_login()) {
			 $this->redirect("User/login" );
		 }
        $tag=input('tag');
		$tag=safe_replace($tag);//过滤
        $shoplist= M('shoplist')->where("tag='$tag'")->select();
        $this->assign('shoplist',$shoplist);
		$this->meta_title = '首页';
		$this->display();
    }

   public function pay_type(){
       if(!is_login()) {
			 $this->redirect("User/login" );
		}

		$this->meta_title = '选择支付方式';
		$this->display();
     }
   public function ship(){
       if(!is_login()) {
			 $this->redirect("User/login" );
		}

		$this->meta_title = '选择支付方式';
		$this->display();
     }
    public function invoice(){
        if(!is_login()) {
			 $this->redirect("User/login" );
		}
       
     	$this->meta_title = '首页';
		$this->display();
     }


}
