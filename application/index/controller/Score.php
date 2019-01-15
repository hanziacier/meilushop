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
class Score extends Home{

	 public function index(){	
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
		$map["order_type"]=1;
		$order="id desc";
		$p=input("page")?input("page"):1;
		$p=safe_replace($p);
        $res["list"]= Db::name("order")->where($map)->limit(10)->page($p)->order($order)->select();
	
		foreach($res["list"] as $n=> $val){
                $res["list"][$n]['sales']=Db::name("sales")->where('order_sn=\''.$val['order_sn'].'\'')->select();
		}
		$list = Db::name("order")->where($map)->order($order)->paginate(10);
		$res["page"] = $list->render();
		$res["info"] = $map;

		//查询条件
		$info=$res["info"];
		$info["status"]=-99;//解除状态
        $this->assign('info',$info);
		
		//dump($info);
		unset($res["info"]);
		//分页数据
        $this->assign('res',$res);
		$this->meta_title ="个人中心";	
		$this->assign('meta_title',$this->meta_title);
		return $this->fetch();
    }

	//立即购买
	 public function create() {
		if ( !is_login()) {
			 $this->error('未登录！', url('user/login'));
			}
		$user=new \app\common\model\Order; 
		$res=$user->score();
		$url=url('score/orderPay?id='.$res);
		 if($res){
		   $this->success("创建成功！",$url);
		 }else{
			   $this->error($user->getError());
		} 

    }

	//保存发票。地址等信息
	public function save($id="") {
		if(!is_login()) {
			$this->error( "您还没有登陆",url("User/login") );
		}	
		$uid=is_login(); 
		$map["uid"]=$uid;
		$id=input('post.id',0);
        if(!($id && is_numeric($id))){
		   $this->error('ID错误！');
		}
		$addressid=input('address_id');
        if(!($addressid&& is_numeric($addressid))){
		   $this->error('未选择地址！');
		}			
		$map["id"]=$id;	
		$info= db("order")->where($map)->find(); 
		if(!$info){
			$this->error( "订单不存在");
		}
        $condition["id"]=$uid;
		$ucenter=db("ucenterMember")->where($condition)->find();
		$score=$ucenter["score"];//积分
        $data["score"]=get_goods($info['goods_id'],"score");
        $total_score=$info["total_money"];
		if($total_score>$ucenter["score"]){
		   $this->error('积分不足！');
		}else{
		   $save["score"]=$ucenter["score"]-$total_score;//积分
		}
		$where["id"]=$addressid;
		$where["uid"]=$uid;
		$adr= db("address")->where($where)->find(); 
		$order=model("order");
		$data=array();
        foreach($_POST as $key=>$val){
		      $data[$key]=safe_replace($val);
             
		}
		$data["username"]=$adr["username"];
        $data["mobile"]=$adr["mobile"];
		$data["status"]=1;
        $data["address"]=$adr["province"].$adr["city"].$adr["area"].$adr["address"];
		$data["update_time"]=time();
        $field=['status','address','mobile','username','address_id','message','total_money','invoice_header','invoice_content','is_invoice','invoice_type'];
	    //$res=db('order')->where($map)->filed($field)->update($data);
		$res=$order->allowField($field)->save($data, $map);
       
		db("ucenterMember")->where($condition)->field("score")->update($save);
		unset($data);
		
		if($res){
		  $pay=db("pay");
		  $data["model"]="order";
		  $data["out_trade_no"]= $info["order_sn"];
		  $data["uid"]=is_login(); 
		  $data["create_time"]=time();
		  $data["total_money"]= isset($save["total_money"])?$save["total_money"]:$info["total_money"];
		  $data["order_id"]=$id;
		  $data["status"]=1;
		  $data["type"]=3;//积分订单
		  $addid=$pay->insertGetId($data);
			
			$url=url('pay/over?id='.$addid);
		    $this->success("创建成功！",$url);
		}else{
			$this->error( "订单不存在");
		}		 
    }
//支付订单
    public function orderpay($id="") {
		  if(!is_login()) {
			$this->error( "您还没有登陆",url("User/login") );
		}	
	     if(!($id && is_numeric($id))){
		   $this->error('ID错误！');
		}
		$uid=is_login(); 
		$map["uid"]=$uid;	
		$map["id"]=$id;	
		$info= db("order")->where($map)->find(); 
		$address=db("address")->where(array("uid"=>$uid))->order("status,create_time")->find();
		$this->assign('info', $info);	
		$this->assign('address', $address);
		unset($map);
		$map["pid"]=0;
		$arealist=db("area")->where($map)->select();
        $this->assign('arealist', $arealist);	
		$map2["uid"]=$uid;	
		$map2["order_sn"]=$info["order_sn"];	
        $list=db("sales")->where($map2)->select();	
		$this->assign('list', $list);	
		return $this->fetch();		 
    }
    public function ordersn_old(){
		$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'input', 'J');
		$orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%04d%02d', rand(1000, 9999),rand(0,99));
		return $orderSn;
	}

    // 生成支付订单号
   public function ordersn(){
        if ( is_login() ) {
		      $uid=is_login();
		      $code=date('Ymd',time()).time().$uid;
	       return $code;
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
    /* 详情页 */
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
