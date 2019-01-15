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
class Order extends Home {
	
	//全部订单		
   public function index(){
       if ( !is_login() ) {
		   $this->redirect("User/login" );
		}
    
        $uid=is_login();
        $page = input('p')?input('p'):1;
        $map['uid']=$uid;//用户id
		$p= input('p')?input('p'):1;
		if(input('status')){
			 $map['status']=input('status');//用户id
		}else{
			$map['status']=["gt",-1];
		}
	    $res=  apiLists('order',$map,"10",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
			foreach($data as &$vo){
				 $vo['html'] =$this->parsehtml($vo['id'],$vo['status']);//商品链接
			     $vo['time'] =  date("Y-m-d h:i",$vo['create_time']);//时间
				 $vo["status_msg"]=$this->parse($vo['status']);
				 $vo['num'] =$this->getNum($vo["order_sn"]);
			}
	   foreach($data as $n=> $val){
          // 订单包含商品
		  $where["order_sn"]=$val["order_sn"];
          $data[$n]['child']=db("sales")->where($where)->select(); 
          foreach($data[$n]['child'] as &$vo){
                    $cover_id= get_goods($vo['goods_id'],"cover_id");
                    $vo['image'] = get_cover($cover_id,'path');//商品图片
                    $vo['title'] = get_goods($vo['goods_id'],"title");//商品图片
					$vo['title'] =substr_cn($vo['title'],35);
                }
            }		
		}
	
       // $data = $res['list'];
	    $this->meta_title = '我的收藏';
	    if($_POST){		 
			   //AJAX刷新数据
            return $data;
			
       }else{
            $res['status']=input('status')?input('status'):'';
     		$this->assign('maxnum',$res['pagenum']);// 赋值数据集
         //dump($data);/dump($data);
           $this->assign('res',$res);// 赋值数据集 
           $this->assign('data',$data);// 赋值数据集 
            return $this->fetch();
       }
	 
	
    }
    public function getNum($order_sn) { 
	   
        $sum =0;
		$where["order_sn"]=$order_sn;
        $data = db("sales")->where($where)->select();
        foreach ($data as $k=>$item) {
			$sum+=intval($item['num']);
         
        }
        return  $sum;
    }
	 public function parsehtml($id,$status){   
	       switch ($status)
				{
				case 1:
				  return '<a href="'.url('order/detail?id='.$id).'">详情</a>';
				  break;
				case 2:
				  return '<a href="'.url('order/detail?id='.$id).'">详情</a>
				<a onclick="confirm('.$id.')">确认</a>';
				  break;
				case 3:
				  return'<a href="'.url('order/detail?id='.$id).'">详情</a>
				';
				  break;
				default:
				  return '<a href="'.url('order/detail?id='.$id).'">详情</a>
				<a href="'.url('pay/index?id='.$id).'">支付</a>';
				}
	}
	/**
     * 解析状态
     */
	 public function parse($status){   
	       switch ($status)
				{
				case 1:
				  return "待发货";
				  break;
				case 2:
				  return "已发货";
				  break;
				case 3:
				  return "已确认";
				  break;
				default:
				  return  "未支付";
				}
	}
	//已完成订单		
   public function hasover(){
       if ( !is_login() ) {
		    $this->redirect("User/login" );
		}
      
        $uid=is_login();
		$map['uid']=$uid;
		$map['status']=3;
		$list=D("order")->getLists($map);
	    $this->assign('list',$list);// 赋值数据集     
		$page=D("order")->getPage($map);
		$this->assign('page',$page);//  
	    $this->meta_title = '我的收藏';
	    return $this->fetch();
	
    }
   //待支付订单
    public function on_pay(){
       if ( !is_login() ) {
		   $this->redirect("User/login" );
		}
     
        $uid=is_login();
        $page = input('p')?input('p'):1;
		$map['status']=0;
		$map['uid']=$uid;
        $res= model('order')->getList('id desc',$map,$page,5);
        $data = $res['list'];
	    $this->meta_title = '我的收藏';
	    if($_POST){		 
			   //AJAX刷新数据
            return $data;
			
       }else{
             $this->assign('maxnum',$res['num']);// 赋值数据集
          $this->assign('list',$data);// 赋值数据集
     		$this->assign('res',$res);// 赋值数据集   
            return $this->fetch();
       }
	
    }
	 //待发货订单
   public function on_way(){
       if ( !is_login() ) {
		     $this->error( "您还没有登陆",U("User/login") );
		}
        if ( !is_login() ) {
			$this->error( "您还没有登陆",U("User/login") );
	    }
        $uid=is_login();		
		$map['uid']=$uid;
		$map['status']=1;
		$list=D("order")->getLists($map);
	    $this->assign('list',$list);// 赋值数据集     
		$page=D("order")->getPage($map);
		$this->assign('page',$page);//  
	    $this->meta_title = '我的收藏';
	    return $this->fetch();
	
    }
    //待确认订单
    public function on_confirm(){
        if ( !is_login() ) {
		     $this->error( "您还没有登陆",U("User/login") );
		}
        $uid=is_login();		
		$map['uid']=$uid;
		$map['status']=2; 
		$page = input('p')?input('p'):1;
		$res= model('order')->getList('',$map,$page,5);
        $this->assign('page',$res['page']);
        $data = $res['list'];
	    $this->meta_title = '待确认订单';
	    if($_POST){		 
			   //AJAX刷新数据
            return $data;
			
       }else{
            $this->assign('list',$data);// 赋值数据集     		
            return $this->fetch();
       }
	
    }
  /**
 * 生成订单信息
 * 
 */ public function all(){
        if ( !is_login() ) {
				$this->error( "您还没有登陆",U("User/login") );
			}		
       
		$Order=new \app\index\model\Order;
		$res=$Order->getPageList(2,"id desc") ;
		$this->assign('res',$res);
		
		$this->meta_title ="个人中心";	
		$this->assign('meta_title',$this->meta_title);
		return $this->fetch();
    }
	//购物车提交
    public function add() {
		if ( !is_login() ) {
				$this->error( "您还没有登陆",U("User/login") );
			}
		$uid=is_login(); 
		$id=input('post.id');
	   	$ids=explode(",",$id);
        $map[]=["uid",'=',$uid];	
        $map[]=["sku_id","in",$ids];		
		$cart = db("cart")->where($map)->select();
		if(!$cart){
			$this->error( "选择错误");
		}
		$sum = 0;$price = 0.00;
		$sn=$this->ordersn();
		$sales=db("sales");
		$saleslist="";$reduction=array();
		 foreach ($cart as $key=>$val) {
			    //计算满减优惠
			    if($val['reduction_id']>0){
					array_push($reduction,$val['reduction_id']);
				}

				$key="cart.".$val['sku_id'];	
                $condition["id"]=$val['id'];
                unset($val['id']);unset($val['key']);				 
				unset($val['path']);unset($val['reduction']);
				
				$xji=$val['num']*$val['price'];
				$price += $xji;
				$val["title"]=get_goods($val['goods_id'],"title");
				$val["total"]=$xji;
				$val["order_sn"]=$sn;
				db("sales")->insert($val);
			    $saleslist .="{$val["title"]} {$val['specifications']} 数量{$val['num']} 单价{$val['price']} 小计$xji</br>";//标识号
				
				
				$res = db("cart")->where($condition)->delete();
                session($key,null);

				
                 
		   }
		 $data["total"]=$price;
		 $data["reduction"]= $this->compute($reduction,$sn);
		 $data["total_money"]=$price-$data["reduction"];
		 $data["saleslist"]=$saleslist;
         $data["uid"]=$uid;	
         $data['status']=0;
		 $data["order_sn"]=$sn;
		 $data["create_time"]=time();
		 $res=db("order")->insertGetId($data);
		 $data['status']=1;
		 $data["id"]=$res; 
		 $data["url"]=url('order/orderPay?id='.$res);
		 return $data;		 

    } 
	//计算满减优惠
	 public function compute($reduction,$sn) {
		 if(!C("IS_MANG")){
		   return false; //没有开启满减优惠，返回false
		 }
		if ( !is_login()) {
				$this->error( "您还没有登陆",url("User/login") );
	     }
		 $uid=is_login();
		 $map=["id","in",$reduction];$total_money=0.00;
		 $list=db("reduction")->where($map)->select();
         foreach ($list as $key=>$val) {
		   if($val["end_time"]<time()){
		       $map2["id"]=$val["id"];
			   $map2["uid"]=$uid; 
			   $map2["order_sn"]=$sn;
			   $price = 0.00;
               $data=db("sales")->where($map2)->select(); 
		        foreach ($data as $key=>$v) {
		           $price +=$v["total"];
		       }
			  if($val["total"]<$price){
			     $total_money+=$val["total_money"];
			  }
		   }
		 }
		return $total_money;	
	 }
	//立即购买
	 public function create() {
		if ( !is_login()) {
				$this->error( "您还没有登陆",url("User/login") );
			}
		$uid=is_login(); 
		$num=safe_replace(input('num'));
		if(!($num && is_numeric($num))){
		   $this->error('分类ID错误！');
		}
		$goodsid=input('post.goodsid'); // 用intval过滤$_POST['id']
        $path=input('post.path');
		if($path){
		    $map['path']=safe_replace($path);
		}
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
		$val["uid"]=$uid;
		 db("sales")->insert($val);
		 $arr=explode(',',$info['path']);$specifications="";
						   foreach($arr as $v){
						     $specifications.="&nbsp;".get_specs_title($v) ;
						   }
		 $saleslist ="{$info["title"]} {$specifications} 数量{$num} 单价{$info['price']} 小计$total</br>";//标识号 
		 $ship_price=get_goods($info['goods_id'],"spress");
		 $data["total"]=$total;

		 $data["ship_price"]=$ship_price;
		 $data["total_money"]=$total+$ship_price;
		 $data["saleslist"]=$saleslist;
         $data["uid"]=$uid;	
         $data['status']=0;
		 $data["order_sn"]=$sn;
		 $data["create_time"]=time();
		 $res=db("order")->insertGetId($data);
		 $url=url('order/orderPay?id='.$res);
		 if($res){
		   $this->success("创建成功！",$url);
		 }else{
			 $this->error("创建失败！");
		 }	 

    }
	//支付订单
    public function orderpay($id="") {
		if ( !is_login() ) {
				$this->error( "您还没有登陆",U("User/login") );
	     }
		 if(!$id){
			$id=session("order_id");  
		}
	    if(!($id && is_numeric($id))){
		   $this->error('ID错误！');
		}
		$uid=is_login(); 
		 if(input('aid')){
			 $condition["id"]=safe_replace(input('aid'));	
			
		 } 
		$condition["uid"]=$uid;
		$address=db("address")->where($condition)->order("status desc,create_time desc")->find();
		$map["uid"]=$uid;	
		$map["id"]=$id;	
		$info= db("order")->where($map)->find();
		if(!$info){
			  $this->error('订单不存在！');
		}
		if(!$address){
			$id=$info["id"];
			$data["url"]=url('choose/add?id='.$id);
			$this->redirect($data["url"]);
		}
		if($info["status"]){
			  $this->error('已支付过！');
		}
		$this->assign('info', $info);	
		$this->assign('user', $address);
		$map2["uid"]=$uid;	
		$map2["order_sn"]=$info["order_sn"];	
        $list=db("sales")->where($map2)->select();	
		$this->assign('list', $list);	
		return $this->fetch();		 
    }
	//保存发票。地址，积分等信息
	public function save($id="") {
		if ( !is_login() ) {
				$this->error( "您还没有登陆",U("User/login") );
		}
		
		$id=intval(input('post.id'));
        if(!($id && is_numeric($id))){
		   $this->error('ID错误！');
		}
		$addressid=intval(input('post.address_id'));
        if(!($addressid&& is_numeric($addressid))){
		   $this->error('未选择地址！');
		}	
		$uid=is_login(); 
		$map["uid"]=$uid;		
		$map["id"]=$id;	
		$info= db("order")->where($map)->find(); 
		if(!$info){
			$this->error( "订单不存在");
		}
		$save=array();
        foreach($_POST as $key=>$val){
		      $save[$key]=safe_replace($val);
             
		}
		unset($save['id']);
		$order=new \app\index\model\Order;
        if(!$_POST["id"]){
			//使用积分
            $condition["id"]=$uid;
			$ucenter=db("ucenterMember")->where($condition)->find();
			$score_money=$ucenter["score"]/1000;
			$save["score"]=$ucenter["score"];//积分
			$save["score_money"]=$score_money;//积分抵消金额
            $save["total_money"]=$info["total_money"]-$score_money;
			$data["score"]=$ucenter["score"];//积分
			$data["score_money"]=$score_money;//积分抵消金额
		}
		
		$where["id"]=$addressid;
		$where["uid"]=$uid;
		$adr= db("address")->where($where)->find(); 
		$save["username"]=$adr["username"];
        $save["mobile"]=$adr["mobile"];
		$save["paytype"]=intval(input('post.paytype'));
        $save["address"]=$adr["province"].$adr["city"].$adr["area"].$adr["address"];
		$save["update_time"]=time();
        $field="address,mobile,username,address_id,paytype,express,score,message,total_money,invoice_header,invoice_content,is_invoice,invoice_type,update_time";
		$res=db("order")->where($map)->field($field)->update($save);
		if($res){ 
		  $pay=db("pay");
		  $data["model"]="order";
		  $data["out_trade_no"]= $info["order_sn"];
		  $data["uid"]=is_login(); $data["paytype"]=(int)input('post.paytype');
		  $data["create_time"]=time();
		  $data["total_money"]= isset($save["total_money"])?$save["total_money"]:$info["total_money"];
		  $data["order_id"]=$id;
		  $data["type"]=2;//订单
		  $addid=$pay->insertGetId($data);
		  
		  //商品订单 
		  session("type",null);
		  session("type",2);
		  $data["status"]=1;
		  $data["stype"]= session("type");
		  $param['id'] = $info['id'];
		  //微信浏览器提交微信支付
          if( is_weixin()){
			    $param['id'] = $addid;
				$url=url('Pay/wxpay', $param);
		   }//支付宝，余额支付，货到付款
		   else{
			   $data['code']=1;
		       $data["id"]=$id;
			   $url=url('pay/index?id='.$id);
			 
		   }
		   $this->success( "保存成功",$url);
		}else{
			$this->error( "订单不存在");
		}		 
    }
	public function Pay($id="") {
		if ( !is_login() ) {
				$this->error( "您还没有登陆",U("User/login") );
		}
		$uid=is_login(); 
		$map["uid"]=$uid;	
		$map["id"]=$id;	
		$info= db("order")->where($map)->find(); 
		$address=db("address")->where(array("uid"=>$uid))->order("status")->find();
		$this->assign('info', $info);	
		$this->assign('address', $address);
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
    /* 文档模型频道页 */
	public function detail($id=0){
		if ( !is_login() ) {
		     $this->error( "您还没有登陆",U("User/login") );
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
		$info["wuliu"]=$this->getkuaidi($info["express"],$info["express_code"]);
        $this->assign('info',$info);
		$list=db("sales")->where('order_sn=\''.$info['order_sn'].'\'')->select();
		$this->assign('list',$list);
		$this->meta_title = '订单详情';
		$this->assign('meta_title',$this->meta_title);
		
		return $this->fetch();
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
			  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
			  $get_content = curl_exec($curl);
			  curl_close ($curl);
		 }else{
			  include(ROOT_PATH.'extend/Snoopy/Snoopy.php');
			  $snoopy=new \Snoopy();
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
			$this->error( "您还没有登陆",U("User/login") );
		}
		$tag=input('id');
        $id=safe_replace($id);//过滤
		$map["id"]=array("in",$id);
		$map["uid"]=is_login();
		$map["status"]=array("gt",2);
		if(db("order")->where($map)->select()){
			$res=db("order")->where($map)->delete();		
		    db("shoplist")->where($map)->delete();
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
			$this->error( "您还没有登陆",U("User/login") );
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
