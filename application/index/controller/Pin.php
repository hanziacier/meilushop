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
/**
 * 订单模型控制器
 * 文档模型列表和详情
 */
class Pin extends Home{
	
	/**
 * 生成订单信息
 * 
 */ public function index(){
        if ( !session_uid() ) {
				$this->redirect("User/login");
		}		
        $Order=new \app\index\model\Order;
		 if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$value=safe_replace($value);$key=safe_replace($key);
					$map[$key]  = ['like', '%'.$value.'%'];
				 }
			}
        }
		if (isset($map['start_time']) ) {
			  unset($map['start_time']);
              $map['create_time'] = array('egt',strtotime($_POST['start_time']));
        }
        if (isset($map['end_time']) ) {
			unset($map['end_time']);
            $map['create_time'] = array('elt',strtotime($_POST['end_time']));
        }
		if(input('status')){
		   $map['status'] = input('status');
		}else{
		
		  // $map["status"]=array("gt",0);
		}
		$map["uid"]=is_login();
		$map["order_type"]=2;
		$order="id desc";
		$p=input("page")?input("page"):1;
		$p=safe_replace($p);
        $res["list"]= Db::name("order")->where($map)->limit(10)->page($p)->order($order)->select();
		foreach($res["list"] as &$vo){
                $vo['n']=getmaxnum($vo["goods_id"]);
		}
		foreach($res["list"] as $n=> $val){
                $res["list"][$n]['sales']=Db::name("sales")->where('order_sn=\''.$val['order_sn'].'\'')->select();
		}
		$list = Db::name("order")->where($map)->order($order)->paginate(10);
		$res["page"] = $list->render();
		$res["info"] = $map;

		//查询条件
		$info=$res["info"];
        $this->assign('info',$info);
		//dump($info);
		unset($res["info"]);
		//分页数据
        $this->assign('res',$res);
		$this->meta_title ="个人中心";	
		$this->assign('meta_title',$this->meta_title);
		return $this->fetch();
    }
  /**
 *订单信息
 * 
 */ public function progress(){
        if ( !is_login() ) {
				$this->redirect("User/login");
			}		
       
		 $Order=new \app\index\model\Order;
		 if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$value=safe_replace($value);$key=safe_replace($key);
					$map[$key]  = ['like', '%'.$value.'%'];
				 }
			}
        }
		if (isset($map['start_time']) ) {
			  unset($map['start_time']);
              $map['create_time'] = array('egt',strtotime($_POST['start_time']));
        }
        if (isset($map['end_time']) ) {
			unset($map['end_time']);
            $map['create_time'] = array('elt',strtotime($_POST['end_time']));
        }
		if(input('status')){
		   $map['status'] = input('status');
		}else{
		
		  // $map["status"]=array("gt",0);
		}
		$map["uid"]=is_login();
		$map["order_type"]=2;
		$map["pin_status"]=1;
		$order="id desc";
		$p=input("page")?input("page"):1;
		$p=safe_replace($p);
        $res["list"]= Db::name("order")->where($map)->limit(10)->page($p)->order($order)->select();
		foreach($res["list"] as &$vo){
                $vo['n']=getmaxnum($vo["goods_id"]);
		}
		foreach($res["list"] as $n=> $val){
                $res["list"][$n]['sales']=Db::name("sales")->where('order_sn=\''.$val['order_sn'].'\'')->select();
		}
		$list = Db::name("order")->where($map)->order($order)->paginate(10);
		$res["page"] = $list->render();
		$res["info"] = $map;

		//查询条件
		$info=$res["info"];
        $this->assign('info',$info);
		//dump($info);
		unset($res["info"]);
		//分页数据
        $this->assign('res',$res);
		$this->meta_title ="个人中心";	
		$this->assign('meta_title',$this->meta_title);
		return $this->fetch();
    }
  /**
 *订单信息
 * 
 */ public function end(){
        if ( !is_login() ) {
				$this->redirect("User/login");
			}		
       
		 $Order=new \app\index\model\Order;
		 if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$value=safe_replace($value);$key=safe_replace($key);
					$map[$key]  = ['like', '%'.$value.'%'];
				 }
			}
        }
		if (isset($map['start_time']) ) {
			  unset($map['start_time']);
              $map['create_time'] = array('egt',strtotime($_POST['start_time']));
        }
        if (isset($map['end_time']) ) {
			unset($map['end_time']);
            $map['create_time'] = array('elt',strtotime($_POST['end_time']));
        }
		if(input('status')){
		   $map['status'] = input('status');
		}else{
		
		  // $map["status"]=array("gt",0);
		}
		$map["uid"]=is_login();
		$map["order_type"]=2;
		$map["pin_status"]=2;
		$order="id desc";
		$p=input("page")?input("page"):1;
		$p=safe_replace($p);
        $res["list"]= Db::name("order")->where($map)->limit(10)->page($p)->order($order)->select();
		foreach($res["list"] as &$vo){
                $vo['n']=getmaxnum($vo["goods_id"]);
		}
		foreach($res["list"] as $n=> $val){
                $res["list"][$n]['sales']=Db::name("sales")->where('order_sn=\''.$val['order_sn'].'\'')->select();
		}
		$list = Db::name("order")->where($map)->order($order)->paginate(10);
		$res["page"] = $list->render();
		$res["info"] = $map;

		//查询条件
		$info=$res["info"];
        $this->assign('info',$info);
		//dump($info);
		unset($res["info"]);
		//分页数据
        $this->assign('res',$res);
		$this->meta_title ="个人中心";	
		$this->assign('meta_title',$this->meta_title);
		return $this->fetch();
    }
	/**
 *拼团订单退款
 * 
 */  
	 public function over(){
        if ( !is_login() ) {
				$this->redirect("User/login");
			}		
       
		 $Order=new \app\index\model\Order;
		 if($_POST){
			foreach ($_POST as $key=>$value){
				if($value){
					$value=safe_replace($value);$key=safe_replace($key);
					$map[$key]  = ['like', '%'.$value.'%'];
				 }
			}
        }
		if (isset($map['start_time']) ) {
			  unset($map['start_time']);
              $map['create_time'] = array('egt',strtotime($_POST['start_time']));
        }
        if (isset($map['end_time']) ) {
			unset($map['end_time']);
            $map['create_time'] = array('elt',strtotime($_POST['end_time']));
        }
		if(input('status')){
		   $map['status'] = input('status');
		}else{
		
		  // $map["status"]=array("gt",0);
		}
		$map["uid"]=is_login();
		$map["order_type"]=2;
		$map["pin_status"]=3;//退款
		$order="id desc";
		$p=input("page")?input("page"):1;
		$p=safe_replace($p);
        $res["list"]= Db::name("order")->where($map)->limit(10)->page($p)->order($order)->select();
		foreach($res["list"] as &$vo){
                $vo['n']=getmaxnum($vo["goods_id"]);
		}
		foreach($res["list"] as $n=> $val){
                $res["list"][$n]['sales']=Db::name("sales")->where('order_sn=\''.$val['order_sn'].'\'')->select();
		}
		$list = Db::name("order")->where($map)->order($order)->paginate(10);
		$res["page"] = $list->render();
		$res["info"] = $map;

		//查询条件
		$info=$res["info"];
		$info["status"]=-99;
        $this->assign('info',$info);
		//dump($info);
		unset($res["info"]);
		//分页数据
        $this->assign('res',$res);
		$this->meta_title ="个人中心";	
		$this->assign('meta_title',$this->meta_title);
		return $this->fetch();
    }
	//购物车提交
    public function add() {
		if ( !is_login() ) {
				 $this->error('未登录！', url('user/login'));
		} 
		$user=new \app\common\model\Order; 
		$res=$user->add();
		if($res){
			$data['status']=1;
		    $data["id"]=$res; 
		    $data["url"]=url('order/orderPay?id='.$res);
		    return $data;	
	     }else{
			   $this->error($user->getError());
		}
			 

    }
    public function getPricetotal($tag) { 
        $tag=safe_replace($tag);//过滤
        $data = db("shoplist")->where("tag='$tag'")->select();
        foreach ($data as $k=>$val) {
			$price=$val['price'];
            $total += $val['num'] * $price;
        }
       addUserLog('$total'.$tag); 
	   return sprintf("%01.2f", $total);
    }
 
    public function getpriceNum($id) { 
	    $id=safe_replace($id);//过滤
        $price = 0.00;
        $data = db("shoplist")->where("tag='$id'")->select();
        foreach ($data as $k=>$item) {
            $sum += $item['num'];
        }
        return  $sum;
    }

    public function  getyunfee(){

        $data = db("order")->where("tag='$tag'")->select();
        foreach ($data as $k=>$val) {
			$price=$val['shipprice'];
            $total +=  $price;
        }
        return sprintf("%01.2f", $total);
    

}
    /* 文档模型频道页 */
	public function detail($id=0){
		if ( !is_login() ) {
		     $$this->redirect("User/login");
		}
        if(!($id && is_numeric($id))){
		   $this->error('ID错误！');
		}
		$uid=is_login(); 
		$map["uid"]=$uid;	
		$map["id"]=$id;	
		$info= db("order")->where($map)->find();
		if(!$info){
			$this->error( "订单不存在");
		}
        $this->assign('info',$info);
		$list=db("sales")->where('order_sn=\''.$info['order_sn'].'\'')->select();
		$this->assign('list',$list);
		$this->meta_title = '订单详情';
		$this->assign('meta_title',$this->meta_title);
		return $this->fetch();
	}


	public function wuliu(){
		if ( !is_login() ) {
		    $$this->redirect("User/login");
		}
		$id= input('get.orderid','','strip_tags');//获取id
		$id =safe_replace($id);//过滤
		$this->meta_title = '订单'.$id.'物流详情';
		$typeCom=db("order")->where("orderid='$id'")->getField("tool");
		$typeNu=db("order")->where("orderid='$id'")->getField("toolid");
		if (isset($typeCom)&&$typeNu){
		    $retData=$this->getkuaidi($typeCom,$typeNu );
		    addUserLog('查询快递', is_login())  ;
		}
		else{
		  $retData="";
		}
		$this->assign('kuaidata', $retData);		
		$this->display();
	}



    public function getkuaidi($typeCom,$typeNu ){
		$AppKey=C('100KEY');//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
		$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=2&muti=1&order=asc';
		//请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
		$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';
		//优先使用curl模式发送数据
		if (function_exists('curl_init') == 1){
			  $curl = curl_init();
			  curl_setopt ($curl, CURLOPT_URL, $url);
			  curl_setopt ($curl, CURLOPT_HEADER,0);
			  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
			  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
			  curl_setopt ($curl, CURLOPT_TinputMEOUT,5);
			  $get_content = curl_exec($curl);
			  curl_close ($curl);
		 }else{
			  Vendor("Snoopy.Snoopy");
			  $snoopy=new \Vendor\Snoopy\Snoopy();
			  $snoopy->referer = 'http://www.google.com/';//伪装来源
			  $snoopy->fetch($url);
			  $get_content = $snoopy->results;
		}
		return $get_content;
		//print_r($get_content . '<br/>' . $powered);
    }
	//删除订单
	public function del() {
		if ( !is_login() ) {
			$$this->redirect("User/login");
		}
		$tag=input('id');
        $id=safe_replace($id);//过滤
		$map["id"]=array("in",$id);
		$map["uid"]=is_login();
		$map["status"]=array("gt",2);
		if(db("order")->where($map)->select()){
			$res=db("order")->where($map)->delete();		
		    db("sales")->where($map)->delete();
			if($res) { 
			 $this->success('删除成功！');
		   }else{
		      $this->error('删除失败！');
		   }
		}else{
			 $this->error('不支持的订单状态！');
		}
	}

    //确认收货
	public function confirm(){
		if ( !is_login() ) {
			$$this->redirect("User/login");
		}
       	$id=safe_replace(input("id"));
		if(!$id){
			 $this->error("未选择数据！");
		}
		$map['id']=array("in",$id);
		$map['uid']=is_login();
		$map["status"]=2;
		$list=db("order")->where($map)->select();
        if (!$list) {
			$this->error( "订单不存在或存在不支持确认的订单");
		}
		$data["status"]=3;
		$res=db("order")->where($map)->update($data);
       	if($res) { 
			$this->success('确认成功！');
		}else{
		   $this->error('确认失败！');
		}	
     }
}
