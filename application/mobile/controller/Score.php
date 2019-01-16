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
namespace app\mobile\controller;
use think\Controller;
use think\Db;
/*购物车*/
class Score extends Home{
	
	public function index() {
		   if ( !is_login() ) {
			  $this->redirect("User/login" );
		}	
		 $meta_title = '我的购物车';
		  $this->assign('meta_title', $meta_title);
          $lists=lists("goods",'',"9","id desc");
		  $this->assign('list',$lists);
	      return $this->fetch();
		
	}
	/*积分签到*/
	public function add($id){
		if(!is_login() ) {
			//$this->error( "您还没有登陆",url("User/login") );
		}
		
		if(!is_numeric($id)){
		         $this->error('id错误！');
		 }
		$map["id"]=(int)$id;
		$map["status"]=1;//正常上架的商品
		$info=db('goods')->where($map)->find();
	
		if(!$info){
		      $this->error('商品不存在！');
		}
		db('goods')->where($map)->setInc("view");
	    $this->assign("info",$info);
	      return $this->fetch();
	}  
	// 生成支付订单号
   public function ordersn(){
        if ( is_login() ) {
		      $uid=is_login();
		      $code=date('Ymd',time()).time().$uid;
	       return $code;
		}
    }
	/*积分签到*/
	public function save($id){
		if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		$num=(int)safe_replace(input('num'));
		if(!($num && is_numeric($num))){
		   $this->error('数量错误！');
		}
		if(!input('username')){
		   $this->error('用户名不能为空！');
		}
		if(!input('mobile')){
		   $this->error('手机号不能为空！');
		}
		if(!input('address')){
		   $this->error('地址不能为空！');
		}
		$uid=is_login(); 
		$goodsid=(int)input('post.id'); // 用intval过滤$_POST['id']
       
		if($goodsid){
		    $map['goods_id']=safe_replace($goodsid);
		}
		$info=db("sku")->where($map)->find();
        if(!$info){
		   $this->error('sku不存在！');
		}
		if(!$info['num']){
		   $this->error('sku库存数量为0！');
		} 
		$condition["id"]=$uid;
		$ucenter=db("ucenterMember")->where($condition)->find();
		$score=$ucenter["score"];//积分
        $data["score"]=get_goods($info['goods_id'],"score");
        $total_score=$data["score"]*$num;
		if($total_score>$ucenter["score"]){
		   $this->error('积分不足！');
		}else{
		   $save["score"]=$ucenter["score"]-$total_score;//积分
		}

		$sum = 0;$price = 0.00;
		$sn=$this->ordersn();
	    $val["sku_id"]=$info["id"];
		$total=$num*$info['price'];
		$val["title"]=get_goods($info['goods_id'],"title");
		$val["total"]=$total;
		$val["price"]=$info['price'];
        $val["num"]=$num;
		$val["order_sn"]=$sn;
		$val["goods_id"]=$goodsid;
		$val["type"]=1;//积分订单
		$val["uid"]=$uid;
		 db("sales")->insert($val);
		 $saleslist ="{$info["title"]} 数量{$num} 单价{$info['price']} 小计$total</br>";//标识号 
		 $data["total"]=$total;
		 $data["score"]=$total_score;
		 
		 $data["total_money"]=$total;
		 $data["saleslist"]=$saleslist;
         $data["uid"]=$uid;	
         $data['status']=0;
		 $data["order_type"]=1;//积分订单
		 $data["order_sn"]=$sn;
		 $data["create_time"]=time();
		 $data["update_time"]=time();
		 $res=db("order")->insertGetId($data);
		 db("ucenterMember")->where($condition)->field("score")->update($save);
		 if($res){
		   $this->success("兑换成功！");
		 }else{
			 $this->error("兑换失败！");
		 }	 
	}
	/*积分消费明细*/
	public function lists(){
		if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		
		$uid=is_login();
		$this->meta_title = '我的积分';
        $map['uid']=$uid;//用户id
		$p= input('p')?input('p'):1; 
	    $res=  apiLists('score_log',$map,"20",'id desc',$p);
        $data = $res['list']?$res['list']:"";
	
		if($data){
				foreach($data as &$vo){
                   if($vo['type']){
				      $vo['type'] ="+".$vo['score'];
				   }else{
				    $vo['type'] ="-".$vo['score'];
				   }
				   $vo['create_time'] =  date("Y-m-d h:i",$vo['create_time']);//时间
				}
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
}
