<?php
// +----------------------------------------------------------------------
// | yershop [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// |  Author: 烟消云散 <1010422715@qq.com> 
// +----------------------------------------------------------------------
namespace app\mobile\Controller;
use think\Controller;
/**
 * 评论模型控制器
 */
class Comment extends Home {
	//待评价商品
    public  function index() {  
        if ( !is_login() ) {
			  $this->redirect("User/login" );
		}	
	    $uid=is_login();
        $map['uid']=$uid;
        $comment_status= (int)input('comment_status');
		$map['comment_status']= $comment_status? $comment_status:['gt',0];//待评价商品
		$this->meta_title = '待评价商品';
		$p= input('p')?input('p'):1;
		$field="goods_id,id,num,price,order_sn,comment_status";
	    $res=apiLists('sales',$map,"10",'id desc',$p,$field);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				   $vo['image'] = get_goods_cover($vo['goods_id']);
				   $vo['url'] = url('goods/detail?id='.$vo['goods_id']);
				   $vo['title'] = get_goods($vo['goods_id'],'title');
				   $vo['price'] = get_goods($vo['goods_id'],'price');
				   $vo['c_url'] = url('comment/add?id='.$vo['id']);
                   $vo["html"]='<li>
										<div class="wdpj_con01_t">订单编号：'.$vo['order_sn'].'<span>'.$this->parse($vo['order_sn']).'</span></div>
										<div class="wdpj_con01_main">

											<div class="wdpj_con01_img">
												<a href="'.$vo['url'].'"><img src="'.$vo['image'].'" /></a>
											</div>
											<div class="wdpj_con01_text">
												<div class="sc_con01_t">
													<a href="'.$vo['url'].'">'. $vo['title'].'
													</a>
												</div>
												<div class="sc_con01_pri">￥'.$vo['price'].'元</div>

											</div>
										</div>'.$this->parse2($vo['comment_status'],$vo['id'],$vo['c_url']).'
										<div class="wdpj_b">
											<div class="wdpj_b_icon"></div>
											<div class="wdpj_b_text">'.$this->parse3($vo['id']).'</div>
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
/**
     * 解析状态
     */
	 public function parse($order_sn){ 
		 $status=db("order")->where(array('order_sn'=>$order_sn))->value('status');
	       switch ($status)
				{
				case 0:
				  return "待支付";
				  break;
				case 1:
				  return "待发货";
				  break;
				case 2:
				  return "待确认";
				  break;
				default:
				  return  "";
				}
	}
     
	 /**
     * 解析动态
     */
	 public function parse2($status,$id,$url){ 
		if($status==1){
		

			    return '<div class="wdpj_btn">
											<a href="'.$url.'">我要评价</a>
										</div>
';

		}else{
		
		        $content=$this->parse3($id)?$this->parse3($id):'默认好评';
			    return '<div class="wdpj_b">
											<div class="wdpj_b_icon"></div>
											<div class="wdpj_b_text">'.$this->parse3($id).'</div>
										</div>';
		
		}
	 }

/**
     * 解析内容
     */
	 public function parse3($sales_id){ 
		$content=db("comment")->where(array('sales_id'=>$sales_id))->value('content');

		return $content;
	      
	}

    public function add() {
        if ( !is_login() ) {
			  $this->redirect("User/login" );
		}  
		$id=input('id');
			 /* 标识正确性检测 */
		$uid=is_login();
	    if(!($id && is_numeric($id))){
			   $this->error('文档ID错误！');
		}
		$map["id"]=$id;
		$map["uid"]=$uid;
		$info=db('sales')->where($map)->find();
        if ($_POST) {
			 
			 $data["uid"] = $uid; 
			 $data["create_time"] = time(); 
			 $data["goods_id"]=$info["goods_id"];  
			 $data["sales_id"]=$info["id"];
             $data["content"]=safe_replace(input('content')); 
			 $data["score"]=safe_replace(input('score')); 
			 $data["status"]=1;
			 $res=db("comment")->insertGetId($data);
			 if($res>0){ 
				db('sales')->where($map)->setField("comment_status","2");
				$this->success("评价成功",'Comment/index');
				
			  }
         }else {
            
			$this->assign('info',$info);// 赋值数据集  
	        return $this->fetch();
		}  
    }


}
