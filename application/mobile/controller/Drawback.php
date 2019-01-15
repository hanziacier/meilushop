<?php
// +----------------------------------------------------------------------
// | yershop网店管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
// | 版权申明：yershop网店管理系统不是一个自由软件，是贝云网络官方推出的商业源码，严禁在未经许可的情况下
// | 拷贝、复制、传播、使用yershop网店管理系统的任意代码，如有违反，请立即删除，否则您将面临承担相应
// | 法律责任的风险。如果需要取得官方授权，请联系官方http://www.yershop.com
// +----------------------------------------------------------------------
namespace app\mobile\controller;
use think\Controller;
use think\Db;
/**
 * 后台退换货控制器
 */
class Drawback extends Home{
     /* 退换货查询首页 */
	public function index(){     
     
		$map['comment_status']=1;
        $uid=is_login();
		$this->meta_title = '我的收藏';
        $map['uid']=$uid;//用户id
		$p= input('p')?input('p'):1;
	    $res=  apiLists('sales',$map,"10",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				   $vo['image'] = get_goods_cover($vo['goods_id']);
				   $vo['url'] = url('write?id='.$vo['id']);
				   $vo['detail_url'] = url('goods/detail?id='.$vo['goods_id']);
				   $vo['title'] = get_goods($vo['goods_id'],'title');//字符串截取
				   $vo['create_time'] =  date("Y-m-d h:i",$vo['create_time']);//时间
				   $vo['price'] =  get_goods($vo['goods_id'],'price');//价格
				
				    $vo['html'] = '<li>
					
					<div class="sh_con01_m">
						<div class="sd_con02_m">

		   			<div class="sc_con01_img"><a href="'.$vo['detail_url'].'"><img src="'.$vo['image'].'"></a></div>
		   			<div class="sc_con01_text">
		   				<div class="sc_con01_t"><a href="'.$vo['detail_url'].'">'.$vo['title'].'</a></div>
<div class="sc_con01_pri">'.$vo['specifications'].'<span>x'.$vo['num'].'</span></div>
		   			</div>
</div>
<div class="sd_con02_b sd_con02_b0'.$vo['type'].'">'.$this->parse($vo['type']).'</div>
<div class="sd_con02_btn"><a href="'.$vo['url'].'">'.$this->parsetxt($vo['type']).'</a></div>
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
	 public function edit($id){
		if ( !is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		} 
		if(!is_numeric($id)){
		     $this->error('id错误！');
		}
		$map["id"]=$id;
		
		$info=db('Drawback')->where($map)->find();
		if(!$info){
		      $this->error('订单不存在！');
		}
	    if($info["type"]==1){
			if($info["status"]==1){
			   
				$info["msg"]="退货申请中,请等待回复";
			
			}
			if($info["status"]==2){
				
				
				$info["msg"]="已同意退货，请填写快递单号";
			
			}
			if($info["status"]==3){
				
				
				$info["msg"]="已拒绝".$info["reason"];
			
			}
			if($info["status"]==4){
				
				
				$info["msg"]="退货中,买家已发货";
			
			}
			$tml="edit";
		}
		if($info["type"]==2){
			if($info["status"]==1){
			   
				$info["msg"]="换货申请中,请等待回复";
			
			}
			if($info["status"]==2){
				
				
				$info["msg"]="已同意换货，请填写快递单号";
			
			}
			if($info["status"]==3){
				
				
				$info["msg"]="已拒绝".$info["reason"];
			
			}
			if($info["status"]==4){
				
				
				$info["msg"]="换货中,买家已发货";
			
			}
			$tml="edit2";
		}
		if($info["status"]==6){
		    
			
			$info["msg"]="已完成";
		
		}
	    $this->assign("info",$info);
	    $this->meta_title ="申请售后";	
	    $this->assign('meta_title',$this->meta_title);
	    return $this->fetch($tml);
		 
	   }
    /* 退换货查询首页 */
	public function lists(){     
     	if ( !is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		} 
		
        $uid=is_login();
		$this->meta_title = '我的收藏';
        $map['uid']=$uid;//用户id
		$map['type']=(int)input('type');//用户id
		$p= input('p')?input('p'):1;
	    $res=  apiLists('Drawback',$map,"10",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				   $vo['image'] = get_goods_cover($vo['goods_id']);
				   $vo['url'] = url('write?id='.$vo['id']);
				   $vo['detail_url'] = url('goods/detail?id='.$vo['goods_id']);
				   $vo['title'] = get_goods($vo['goods_id'],'title');//字符串截取
				   $vo['create_time'] =  date("Y-m-d h:i",$vo['create_time']);//时间
				   $vo['price'] =  get_goods($vo['goods_id'],'price');//价格
				   $vo['edit_url'] = url('edit?id='.$vo['id']);
				    $vo['html'] = '<li>
					
					<div class="sh_con01_m">
						<div class="sd_con02_m">

		   			<div class="sc_con01_img"><a href="'.$vo['detail_url'].'"><img src="'.$vo['image'].'"></a></div>
		   			<div class="sc_con01_text">
		   				<div class="sc_con01_t"><a href="'.$vo['detail_url'].'">'.$vo['title'].'</a></div>
<div class="sc_con01_pri">'.$vo['specifications'].'<span>x'.$vo['num'].'</span></div>
		   			</div>
</div>
<div class="sd_con02_b sd_con02_b0'.$vo['type'].'">'.$this->parse($vo['type']).'</div>
<div class="sd_con02_btn"><a href="'.$vo['edit_url'].'">'.$this->parsestatus($vo['status']).'</a></div>
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
	 public function parsestatus($status){   
	       switch ($status)
				{
				
				case 1:
				  return "申请中";
				  break;
				case 2:
				  return "同意";
				  break;
				  case 3:
				  return "拒绝";
				  break;
				case 4:
				  return "退货中";
				  break;
				  case 5:
				  return "退款";
				   case 6:
				  return "完成";
				  break;
				default:
				  return  "";
				}
	}
/**
     * 解析类型
     */
	 public function parse($type){   
	       switch ($type)
				{
				
				case 1:
				  return "退货";
				  break;
				case 2:
				  return "换货";
				  break;
				default:
				  return  "";
				}
	}
	/**
     * 解析类型
     */
	 public function parsetxt($type){   
	      if($type){
		  
		   return "查看详情";
		  }
		   return "申请售后";
	}
	  public function write($id){
		if ( !is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		} 
		if(!is_numeric($id)){
		     $this->error('id错误！');
		}
		$map["id"]=$id;
		
		$info=db('sales')->where($map)->find();
		if(!$info){
		      $this->error('订单不存在！');
		}
        $goods=db('goods')->find($info["goods_id"]);
		$cate=db('category')->find($goods["category_id"]);
		$types=db('types')->find($cate["types_id"]);
        $tags=explode("|",$types["tags"]);
		$this->assign('tags',$tags);

	    $this->assign("info",$info);
	    $this->meta_title ="申请售后";	
	    $this->assign('meta_title',$this->meta_title);
	    return $this->fetch();
		 
	   }
     //更新数据
    public function update() {
        if ( !is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		} 
		$id=(int)input('id'); 			
		if(!($id && is_numeric($id))){
		   $this->error('ID错误！');
		}
		$uid=is_login();
		$map["id"]=$id;
		$map["uid"]=$uid;
		$info=db('drawback')->where($map)->select();
		if(!$info){
		      $this->error('订单不存在！');
		}
		
		$save["express"]=safe_replace($_POST["express"]);
		$save["express_code"]=safe_replace($_POST["express_code"]);
		$save["status"]=4;
        $res=db('drawback')->where($map)->field("express,express_code,status")->update($save);
	      if($res){
		      $this->success("提交成功！");
		  }else{
			  $error="提交失败！";
			  $this->error($error);
		  } 
	    
    } //增加数据
	  public function add($id=""){  
	   if(!is_login()) {
		    $this->redirect("User/login");
		}	
	    $id=input('sales_id'); 			
		if(!($id && is_numeric($id))){
		   $this->error('ID错误！');
		}
	
		$map["id"]=$id;
		$map["uid"]=is_login();
		$info=db('sales')->where($map)->find();
		if(!$info){
		      $this->error('订单不存在！');
		}
     
		$data["sales_id"]=safe_replace($_POST["sales_id"]);
		$data["description"]=safe_replace($_POST["description"]);
		$data["type"]=safe_replace($_POST["type"]);
		$data["money"]=safe_replace($info["total"]);
		$data["goods_id"]=safe_replace($info["goods_id"]);
		$data["sku_id"]=safe_replace($info["id"]);
		$data["create_time"]=time();
       $res=db("Drawback")->insertGetId($data);
	   if($res){ 
		   $this->success("提交成功");
		}else{
			 $this->error("提交失败！");
		} 
	  } 
	  
	 public function cancel($id=""){  
	    if(!is_login()) {
		    $this->redirect("User/login");
		}	
	    $id=input('id'); 			
		if(!($id && is_numeric($id))){
		   $this->error('ID错误！');
		}
		$map["id"]=$id;
		$map["uid"]=is_login();
		$info=db('Drawback')->where($map)->find();
		if(!$info){
		      $this->error('订单不存在！');
		}
	    $data["status"]=0;
        // 过滤post数组中的非数据表字段数据
        $res=model("Drawback")->where($map)->update($data);
	    if($res){
		   $url=url( "order/index");
		   $this->success("修改成功！",$url);
		}else{
			 $this->error("修改失败！");
		} 
	  } 
}
