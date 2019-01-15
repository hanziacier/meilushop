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

class Index extends Home{


    public function index(){  
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		$uachar = "/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i";
		if($ua == '' || preg_match($uachar, $ua)){
           $this->redirect("mobile/index/index");;
		}
      if(!is_login()&&cookie('username')&&cookie('password')){
		    $username=cookie('username'); 
            $password=cookie('password'); 
            $username =safe_replace($username);//过滤
			 $map["password"]=$password;	$map["username"]=$username;
			 $user =db('UcenterMember')->where($map)->find();
			 if($user['status']){
			  $uid = $user["id"];
			      $user=new \app\common\model\User; 
			      $user->send($uid);
		    }
       };
		$meta_title="首页";  
		$this->assign('meta_title', $meta_title);
		//幻灯片
	    $slidelist=lists("slide","","10","id desc");
	    $this->assign('slidelist',$slidelist);
		$tree=model("category")->maketree( ) ; 
		$this->assign ( 'tree', $tree );
	    return $this->fetch();
	}

    public function clear(){

       $data ['ip'] =$_SERVER['REMOTE_ADDR'];;
	   $res=db("history")->where($data)->delete();
	   if($res){
		        $this->success("删除成功！");
		   }else{
			  
			    $this->error("删除失败！");
		   } 
      
	} 
  
	 public function tuan(){ 
	     $map['status']=1;
		 $id=52; 
      
		 if(!($id && is_numeric($id))){
		   $this->error('分类ID错误！');
		}else{
		   $where["id"]=$id;
		}	
		$Category=model("category");
		$info=$Category->info($where);
		if(!$info){
		    $this->error('分类不存在！');
		}  
		//当前分类父分类id列表
        $ids=$Category->getParentId($id);
		$info["cate_ids"]=$ids;

        //品牌
        $brandlist=model("Brand")->getlist($id);
		$this->assign('brandlist', $brandlist);

		 //属性列表
		$attr_list=model("Attributes")->getList($info["types_id"]);
		
		$this->assign('attr_list', $attr_list);
		
		//查询数据
		$list=$Category->searchInfo($id);	
		
		//取出分页数据
		$res=$list["data"];
		$this->assign('res', $res);
		unset($list["data"]);
		
		//分类信息及查询条件
		$info=array_merge($info,$list);	
		$this->assign("info",$info);
		
		//商品精选
		$field = 'id,title,price,cover_id,view,comments';
	    $view_list=lists('goods','',6,"view desc",$field);
		$this->assign("view_list",$view_list);
		
		//销售排行
		unset($field);
		$field = 'id,title,price,cover_id,sales,comments';
	    $sales_list=lists('goods','',5,"sales desc",$field);
		$this->assign("sales_list",$sales_list);
		
		$this->assign('meta_title',$info["title"]);
		return $this->fetch();
		$meta_title="闪购";  
		$this->assign('meta_title', $meta_title);
        return $this->fetch( );
	} 
  public function score(){ 
	     $map['status']=1;
		 $id=52; 
      
		 if(!($id && is_numeric($id))){
		   $this->error('分类ID错误！');
		}else{
		   $where["id"]=$id;
		}	
		$Category=model("category");
		$info=$Category->info($where);
		if(!$info){
		    $this->error('分类不存在！');
		}  
		//当前分类父分类id列表
        $ids=$Category->getParentId($id);
		$info["cate_ids"]=$ids;

        //品牌
        $brandlist=model("Brand")->getlist($id);
		$this->assign('brandlist', $brandlist);

		 //属性列表
		$attr_list=model("Attributes")->getList($info["types_id"]);
		
		$this->assign('attr_list', $attr_list);
		
		//查询数据
		$list=$Category->searchInfo($id);	
		
		//取出分页数据
		$res=$list["data"];
		$this->assign('res', $res);
		unset($list["data"]);
		
		//分类信息及查询条件
		$info=array_merge($info,$list);	
		$this->assign("info",$info);
		
		//商品精选
		$field = 'id,title,price,cover_id,view,comments';
	    $view_list=lists('goods','',6,"view desc",$field);
		$this->assign("view_list",$view_list);
		
		//销售排行
		unset($field);
		$field = 'id,title,price,cover_id,sales,comments';
	    $sales_list=lists('goods','',5,"sales desc",$field);
		$this->assign("sales_list",$sales_list);
		
		$this->assign('meta_title',$info["title"]);
		return $this->fetch();
		$meta_title="闪购";  
		$this->assign('meta_title', $meta_title);
        return $this->fetch( );
	} 
  public function shan(){ 
	     $map['status']=1;
		 $id=164; 
      
		 if(!($id && is_numeric($id))){
		   $this->error('分类ID错误！');
		}else{
		   $where["id"]=$id;
		}	
		$Category=model("category");
		$info=$Category->info($where);
		if(!$info){
		    $this->error('分类不存在！');
		}  
		//当前分类父分类id列表
        $ids=$Category->getParentId($id);
		$info["cate_ids"]=$ids;

        //品牌
        $brandlist=model("Brand")->getlist($id);
		$this->assign('brandlist', $brandlist);

		 //属性列表
		$attr_list=model("Attributes")->getList($info["types_id"]);
		
		$this->assign('attr_list', $attr_list);
		
		//查询数据
		$list=$Category->searchInfo($id);	
		
		//取出分页数据
		$res=$list["data"];
		$this->assign('res', $res);
		unset($list["data"]);
		
		//分类信息及查询条件
		$info=array_merge($info,$list);	
		$this->assign("info",$info);
		
		//商品精选
		$field = 'id,title,price,cover_id,view,comments';
	    $view_list=lists('goods','',6,"view desc",$field);
		$this->assign("view_list",$view_list);
		
		//销售排行
		unset($field);
		$field = 'id,title,price,cover_id,sales,comments';
	    $sales_list=lists('goods','',5,"sales desc",$field);
		$this->assign("sales_list",$sales_list);
		
		$this->assign('meta_title',$info["title"]);
		return $this->fetch();
		$meta_title="闪购";  
		$this->assign('meta_title', $meta_title);
        return $this->fetch( );
	} 
	public function get($time){
	date_default_timezone_set("Asia/Shanghai");
    $time2 =time();
    $second = $time - $time2;
	$day = floor($second/(3600*24));
	$second = $second%(3600*24);
	$hour = floor($second/3600);
	$second = $second%3600;
	$minute = floor($second/60);
	$second = $second%60;
   if($day>0){
      return '<span>'.$day.'</span>天<span>'.$hour.'</span>时<span>'.$minute.'</span>分<span>'.$second.'</span>秒';
   }else{
     return '<span>0</span>天<span>0</span>时<span>0</span>分<span>0</span>秒';
   }

  
	
	}
    public function getGoodlist($id=''){

         $id=input( 'id'); // 用intval过滤$_POST['id']; 
		 if(!($id && is_numeric($id))){
		       $this->error('分类ID错误！');
		 }
		 $data =model("category")->getDatalist( $id );
      
		// json_decode对JSON格式的字符串进行编码而json_encode对变量进行 JSON 编码
		return $data;

    }
}
