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

class Goods extends Home{
	//商品列表
    public function lists(){		    			   	 	 
		$id=input('id'); 	
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
		$tpl=get_category($id,'template_lists');
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
		
		
		//$tpl=get_types($info['types_id'],'template_lists');  
		$this->assign('meta_title',$info["title"]);
		return $this->fetch($tpl);
     }	
    //详情页
     public function detail($id){
	    
		 if(!is_numeric($id)){
		         $this->error('id错误！');
		 }
		$map[]=["id",'=',$id];
		$map[]=["status",'=',1];//正常上架的商品
		$info=db('goods')->where($map)->find();
	
		if(!$info){
		      $this->error('商品不存在！');
		}
		db('goods')->where($map)->setInc("view");
	    $this->assign("info",$info);
		//分类
		$cate_id=$info["category_id"];
	    $Category=model("category");
		$ids=$Category->getParentId($cate_id);	
		$this->assign("ids",$ids);
		$cate=db("category")->find($cate_id);
		//$tpl=get_types($cate['types_id'],'template_detail'); 
		 /*商品规格列表筛选*/
		 if($info["specs"]){
			unset($map);
			
			$map[]=["types_id",'=',$cate["types_id"]];
			 
			$map[]=["pid",'=',0];
			$attrlist=db("specs")->where($map)->select();
			$array=explode(",",$info["specs"]);
			foreach ($attrlist as $n=>$vo){
                      $id=$vo['id'];
				      $where=[["pid",'=',$id],["title","in",$array]];	
                      
                        $attrlist[$n]['sid']= array ();
					    $attrlist[$n]['sid']=db("specs")->where($where)->select();  
				 
			 }
			$this->assign("attrlist",$attrlist);

		}
        //库存
		$map2['goods_id']=$id;
	    //sku列表
        $sku2=db("sku")->where($map2)->field("title,num,goods_id,price")->find();
		$this->assign('sku2',$sku2);
		
		//基本属性
		$basic=db("sku ")->where($map2)->select();
		$this->assign('basic',$basic);
		
		//评价标签
		$tags=db("tags")->where($map2)->select();
		$this->assign('tags',$tags);
		
		//评论列表
		$comment=getAjaxLists("comment",$map2,"10","id desc");
		foreach ($comment["list"] as &$v) {
                $v['pictures']= explode(",",$v['cover_id']);
           }
		$comment["count"]=db("comment")->where($map2)->count(); 
		$map2['is_over']=1;
		$comment["is_over_count"]=db("comment")->where($map2)->count();
		unset($map2);
		$map2['goods_id']=$id;
		//$map2['is_picture']=1;
		$comment["is_picture_count"]=db("comment")->where($map2)->count();
		$this->assign('comment',$comment);
		
		//销售记录
		$sales=getAjaxLists("sales",$map2,"10","id desc");
		$sales["count"]=db("sales")->where($map2)->count(); 
		$this->assign('sales',$sales);
		
		
		//看了又看
		unset($map2);
		$map2['status']=1;
		$map2['id']=array("neq",$id);
		$see_list=lists("goods",$map2,3,"id desc");
		$this->assign('see_list',$see_list);
		
		//热销排行top5
		unset($map2);
		$rexiao=lists("goods",'',"6","sales desc");
		$this->assign('rexiao',$rexiao);
		
		//分页防丢失
		session('goodsid',$id);
		$meta_title=$info["title"];
		$this->assign('meta_title',$meta_title);
			//基本属性
		$map2['pid']=0;
		$arealist=db("area ")->where($map2)->select();
		$this->assign('arealist',$arealist);
        unset($data);unset($map);
         
		$data ['ip'] =$_SERVER['REMOTE_ADDR'];;
		$data ['goods_id'] = $id;
		if(!db("history")->where($data)->find()){
		     $data ['create_time'] = time ();
		     $data ['title'] = $info["title"];
		     db ( 'history' )->insert( $data );
		}
		

		return $this->fetch($cate['template_detail']);


			
	}
		/* ajax评论-所有评论 */
    public function showprice(){		    			   

         //查询条件	goodsid		 	 	 
		$map['goods_id']=safe_replace(input("goodsid"));
		$map['path']=safe_replace(input("path"));
	    //sku列表
        $data=db("sku")->where($map)->field("path,goods_id,price,num")->find();
		if($data){
			echo json_encode($data);
		
		}
     }
	
	/* ajax评论-所有评论 */
    public function comment(){		    			   

         //查询条件	goodsid	
		$goodsid=input("goodsid");	 	 	 
		$info["goodsid"]=$goodsid?$goodsid:session('goodsid');
		if($info["goodsid"]){
			session('goodsid',$info["goodsid"]); 
		    $map['goods_id']=$info["goodsid"];
		}
		 //查询条件p	
		$page=input("page");
        if($page){
			session('page',$page); 
		 }		 
	     $page=$page?$page:session('page');
		 $page=$page?$page:1;
		//查询条件p	
		
        if($page){
			session('page',$page); 
		 }		 
	     $page=$page?$page:session('page');
		 $page=$page?$page:1;
		 
		 
		  //查询条件is_over	
		$is_over=input("is_over");	
	    if($is_over){
			//c,$is_over);
		 } 
		 $info["is_over"]=$is_over;
		//是否追加评论
		if($info["is_over"]){ 	
		    $map['is_over']=$info["is_over"];
		}
		
		//查询条件is_picture
		$is_picture=input("is_picture",0);	
		$info["is_picture"]=$is_picture;
		//是否有图片
		if($info["is_picture"]){ 	
		    $map['is_picture']=$info["is_picture"];
		}
		//查询条件not_empty	
		$not_empty=input("not_empty",0);	
		$info["not_empty"]=$not_empty;
		//是否有内容
		if($info["not_empty"]){ 	
		    $map['not_empty']=$info["not_empty"];
		}
		
		$this->assign('info',$info);
         $res=getAjaxLists("comment",$map,"10","id desc",'',$page);
		foreach ($res['list'] as &$v) {
                $v['pictures']= explode(",",$v['cover_id']);
        }
		//$comment["count"]=db("comments")->where($map)->count(); 
		$this->assign('comment',$res);
	
       return $this->fetch("goods/comment");

     }
	   /* ajax销售记录-所有记录 */
    public function sales(){		    			   
	
         //查询条件	goodsid	
		$goodsid=input("goodsid",0,"intval");	 	 	 
		$info["goodsid"]=session('goodsid');
		if($info["goodsid"]){
			session('goodsid',$info["goodsid"]); 
		    $map['goods_id']=$info["goodsid"];
		}
		 //查询条件p	
		$page=input("page");
		$this->assign('info',$info);
        $sales=getAjaxLists("sales",$map,"10","id desc",'',$page);
		$sales["count"]=db("sales")->where($map)->count(); 
		$this->assign('sales',$sales);
		  return $this->fetch("goods/sales");
     }

}
