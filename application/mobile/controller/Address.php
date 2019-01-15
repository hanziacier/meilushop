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
namespace app\mobile\Controller;
use think\Db;
/**
 * 地址模型控制器
 */
class Address extends Home {

	 /* 地址首页 */
	public function index(){
		 if(!session_uid()) {
		    $this->redirect("User/login");
		}			
		$uid=is_login();
        $map['uid']=$uid;
		$this->meta_title = '地址管理';
		$p= input('p')?input('p'):1;
	    $res=apiLists('address',$map,"10",'status desc,id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				   $vo['edit_url'] = url('edit?id='.$vo['id']);
				   $vo['del_url'] = url('del?id='.$vo['id']);
				   $vo["html"]='<li>
					<div class="shdz_con01_main">
						<div class="shdz_con01_t">
							<div class="shdz_con01_tl fl">
								<input type="radio" onclick="set('.$vo['id'].')" value="'.$vo['id'].'"/>设为默认
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
			    addUserLog("edit_ad",session_uid());
		        $this->success("更新成功！",cookie("__forward__"));
		   }else{
			    $error=$Ad->getError();
			    $this->error($error?$error:"更新失败！");
		   } 
	  }
	  else{
		 $map['id']=$id;
		 $info=db("Address")->where($map)->find();
	     $this->assign('info', $info);
		 if(!$info){
			   $this->error( "无对应的地址" );
		  }
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
		$this->error( "您还没有登陆",U("User/login") );
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
			$url=url("address/index");
			$this->success("删除成功",$url);
		}
		else{ 
			
			$this->error("删除失败");
		}
    
   }
   public  function set() {
		if ( !is_login() ) {
			$this->error( "您还没有登陆",U("User/login") );
		} 
		$id=(int)input("id");
		if(!($id && is_numeric($id))){
		       $this->error('用户ID错误！');
		 }
		$uid=is_login(); 
		if($id){
		   $map["uid"]=$uid;	
		   $map["id"]=$id;	
		   $info= db("address")->where($map)->find(); 
		   if(!$info){
			   $this->error( "地址不存在" );
		   }
		    db("address")->where(array("uid"=>$uid))->setField("status",0);
		   $res=db("address")->where($map)->setField("status",1);
		   if($res){
				$url=url("address/index");
				$this->success("设置成功",$url);
			}
			else{ 
				
				$this->error("设置失败");
			}
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
		   if($res){
				addUserLog("edit_ad",session_uid());
				$url=url("address/index");
				$this->success("新增成功！",$url);
		   }else{
				$error= $Address->getError();
				$this->error($error?$error:"新增失败！");
		   } 
		}
		else{

		  $where["pid"]=0;
		  $arealist=db("area")->where($where)->select(); 
		  $this->assign('arealist', $arealist);
		  $this->meta_title="新增地址";
		  $this->assign('meta_title', $this->meta_title);
		  return $this->fetch("add");
		}
	}

}
