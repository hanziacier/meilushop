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
use think\Controller;
use think\Db;
/**
 * 收藏模型控制器
 * 收藏模型列表和详情
 */
class Collect extends Home {
	public function index(){
		if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		
		$uid=is_login();
		$this->meta_title = '我的收藏';
        $map['uid']=$uid;//用户id
		$p= input('p')?input('p'):1;
	    $res=  apiLists('collect',$map,"10",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				   $vo['image'] = get_goods_cover($vo['goods_id']);
				   $vo['url'] = url('goods/detail?id='.$vo['id']);
				   $vo['title'] = get_goods($vo['goods_id'],'title');//字符串截取
				   $vo['create_time'] =  date("Y-m-d h:i",$vo['create_time']);//时间
				   $vo['price'] =  get_goods($vo['goods_id'],'price');//价格
							  //库存
					$map2['goods_id']=$vo['goods_id'];
					//sku列表
					$sku=db("sku")->where($map2)->field("price")->find();
					$this->assign('sku',$sku);
				    $vo['html'] = '<li id="'.$vo['id'].'">
		   			<div class="sc_con01_close"><a  onclick="cancelCollect('.$vo['id'].');"></a></div>
		   			<div class="sc_con01_img"><a href="'.$vo['url'].'"><img src="'.$vo['image'].'"/></a></div>
		   			<div class="sc_con01_text">
		   				<div class="sc_con01_t"><a href="'.$vo['url'].'">'.$vo['title'].'</a></div>
					<div class="sc_con01_pri">￥'.$sku['price'].'元<span>￥'.$vo['price'].'元</span></div>
					<div class="sc_con01_cart"><a onclick="addcart(this,'.$vo['goods_id'].')">加入购物车</a></div>
		   			</div>
		   		</li>';
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
      //增加收藏
    public function add(){
		if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		$id=input('id',0); // 用intval过滤$_POST['id']
		if(!($id && is_numeric($id))){
			$this->error('ID错误！');
		}   
		$data["goods_id"] = $id;
		$data["uid"]=is_login();
		$data["status"]=1;
		$data["create_time"]=time();
		$info=db("collect")->where($data)->find();
		if($info){
		   $this->error( "已收藏过" ); 
		}
		else{	
		   $res=db("collect")->insert($data);
		   if($res){
                   $map["id"] = $id;
				   db("goods")->where($map)->setInc("collect");
				  $this->success("收藏成功");
		   }else{
			    $this->error("收藏失败");
		   } 
	   }   
   }
   public function delete(){
	   if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
	   }
	   $id=input('id'); // 用intval过滤$_POST['id']
	   $id=safe_replace($id);//过滤
	   $map["id"]=array("in",$id); 
	   $map["uid"]=is_login();
	   $res=db("collect")->where($map)->delete();
	   if($res){
		  $this->success("删除成功");
	   }else{
		  $this->error("删除失败");
	   }
   }
}

