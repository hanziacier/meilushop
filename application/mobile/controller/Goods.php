<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\mobile\Controller;
use think\Db;
/**
* 文档模型控制器
* 文档模型列表和详情
*/
class Goods extends Home{

    
     /* 商品列表页 */
    public function lists($id = 0, $p = 1){			
		
        $map['status']=1; 
        $page = input('p')?input('p'):1;
        $id = input('id');
        if(!($id && is_numeric($id))){
				   $this->error('用户ID错误！');
		}
        /* 分类信息 */
		//$Categorys=new \app\wap\model\Category;
		$category["id"] = $id;
        /* 模板赋值并渲染模板 */
	    $this->assign('category', $category);
        
       	$key=input('order');
		$key=safe_replace($key);//过滤
		$sort=input('sort');  
        $sort=safe_replace($sort);//过滤
		if($key){ 
		   if(!is_numeric($key)){
		         $this->error('排序ID错误！');
		   }
		   switch ($key) { 
		        case '1': 
				    $listsort="view {$sort}";
                break;
				case '2':
				   $listsort="id {$sort}";
                  break;				
			   case '3': 
				   $listsort="price {$sort}";
                  break;
                case '4':                    
				   $listsort="sales {$sort}";
					 break;              
		   }  	
	   } 
	   else {
		 $key="2";
		 $see="asc";
		 $order="view";
		 $sort="asc";
		 $listsort=$order." ".$sort;			
	   }
		
       if($sort=="asc"){
		  $see="desc";
	   }
       if($sort=="desc"){
		  $see="asc";
	   }
	   $cate['id']=$id;
       $this->assign("cate", $cate);
       $this->assign('see',$see);
       $this->assign('order',$key);
	   $this->assign('value',$sort);
	   $Goods=new \app\mobile\model\Goods;
       $res= $Goods->getLists($id,$listsort,$map,$page,6);
       $data = $res['list'];if($data){
				foreach($data as &$vo){
					$url=url('goods/detail?id='.$vo['id']);
					$src=get_cover_path($vo['cover_id']);
					$title=substr_cn($vo['title'],16);
				    $vo['html'] = '<li class="item">
						<div class="in_con03_main">
							<div class="in_con03_img">
								<a href="'.$url.'"><img  src="'.$src.'"/></a>
							</div>
							<div class="in_con03_text">
								<a href="'.$url.'">'.$title.'</a>
							</div>
							<div class="in_con03_pri">￥'.$vo['price'].'元</div>
						</div>
					</li>';
				 
				}
		}
	   if(!$_POST){/**大家都在买,推荐位**/
	      $this->assign('list',$data);// 赋值数据集
          $this->assign('maxnum',$res['page']['num']);// 赋值数据集
          return $this->fetch();

        }else{
         
            return $data;
        }
		
	}
     /* 热销列表页 */
    public function hots($p = 1){			
		
        $page = input('p')?input('p'):1;
	    $key=input('order');
		$key=safe_replace($key);//过滤
		$sort=input('sort');  
        $sort=safe_replace($sort);//过滤
		if($key){ 
		   if(!is_numeric($key)){
		         $this->error('排序ID错误！');
		   }
		   switch ($key) { 
		        case '1': 
				    $listsort="view {$sort}";
                break;
				case '2':
				   $listsort="id {$sort}";
                  break;				
			   case '3': 
				   $listsort="price {$sort}";
                  break;
                case '4':                    
				   $listsort="sales {$sort}";
					 break;              
		   }  	
	   } 
	   else {
		 $key="2";
		 $see="asc";
		 $order="view";
		 $sort="asc";
		 $listsort=$order." ".$sort;			
	   }
		
       if($sort=="asc"){
		  $see="desc";
	   }
       if($sort=="desc"){
		  $see="asc";
	   }
	   $cate['id']="";
       $this->assign("cate", $cate);
       $this->assign('see',$see);
       $this->assign('order',$key);
	   $this->assign('value',$sort);
	   //大型公司建议使用$map中小型使用$where
       $where['status']=1;
	   $res=  apiLists('goods',$where,"10",'sales desc,id desc',$p);
        //echo model("goods")->getLastSql();
       $data = $res['list']?$res['list']:"";
	 if($data){
				foreach($data as &$vo){
					$url=url('goods/detail?id='.$vo['id']);
					$src=get_cover_path($vo['cover_id']);
					$title=substr_cn($vo['title'],16);
				    $vo['html'] = '<li class="item">
						<div class="in_con03_main">
							<div class="in_con03_img">
								<a href="'.$url.'"><img  src="'.$src.'"/></a>
							</div>
							<div class="in_con03_text">
								<a href="'.$url.'">'.$title.'</a>
							</div>
							<div class="in_con03_pri">￥'.$vo['price'].'元</div>
						</div>
					</li>';
				 
				}
		}
	   if(!$_POST){/**大家都在买,推荐位**/
	       $this->assign('list',$data);// 赋值数据集
           $this->assign('maxnum',$res['pagenum']);// 赋值数据集
          return $this->fetch();

        }else{
        
		 //AJAX刷新数据
            return $data;
        }
		
	}
/* 秒杀列表页 */
    public function ms($p = 1){			
		/*内容页统计代码实现，status=2*/
		if(1==C('IP_TONGJI')){
		   $record=IpLookup("",2,$id);
		}
        $page = input('p')?input('p'):1;

		$time=date('H',time());
		if($time>=10&&$time<15){$end=date('Y/m/d',time())." 15:00:00";$type=1;}
		if($time>=15&&$time<20){$end=date('Y/m/d',time())." 20:00:00";$type=2;}
		if($time>=20&&$time<22){$end=date('Y/m/d',time())." 22:00:00";$type=3;}
        if($time>=22&&$time<24){$end=date('Y/m/d',time())." 23:59:59";$type=4;}
        if($time>=0&&$time<10){$end=date('Y/m/d',time())." 9:59:59";$type=5;}
		$this->assign('time',(int)$time);// 赋值数据集
		$this->assign('end',$end);// 赋值数据集
       
       $map['status']=1;
       if($type=1){
           $map['start_time']=array('gt', strtotime(date('Y/m/d',time())." 10:00:00"));
           $map['end_time']=array('lt',strtotime(date('Y/m/d',time())." 15:00:00"));
		   $where['category_id']=167;
       }
  
      if($type=2){
	    $map['start_time']=array('gt', strtotime(date('Y/m/d',time())." 15:00:00"));
        $map['end_time']=array('lt',strtotime(date('Y/m/d',time())." 20:00:00"));
		$where['category_id']=168;
	  }
       if($type=3){
        
		  $map['start_time']=array('gt', strtotime(date('Y/m/d',time())." 20:00:00"));
          $map['end_time']=array('lt',strtotime(date('Y/m/d',time())." 22:00:00"));
		  $where['category_id']=169;
	 }
      if($type=4){
          $map['start_time']=array('gt', strtotime(date('Y/m/d',time())." 22:00:00"));
          $map['end_time']=array('lt',strtotime(date('Y/m/d',time())." 23:59:59"));
		  $where['category_id']=170;
		
	   } 
       if($type=5){
		  $map['start_time']=array('gt', strtotime(date('Y/m/d',time())." 00:00:00"));
          $map['end_time']=array('lt',strtotime(date('Y/m/d',time())." 9:59:59"));
		  $where['category_id']=171;
	   }   
       unset($map);
	   //大型公司建议使用$map中小型使用$where
       $where['status']=1;
	   $res=  apiLists('goods',$where,"10",'id desc',$p);
        //echo model("goods")->getLastSql();
       $data = $res['list']?$res['list']:"";
	   if($data){
            //重组数据
            foreach($data as &$vo){
               $vo['image'] = get_cover($vo['cover_id'],'path');
               $vo['url'] = U('goods/detail?id='.$vo['id']);
               $vo['title'] = substr_cn($vo['title']);//字符串截取
                $vo['percent'] = round( (float) ($vo['sales']/$vo['num'])*100,2)."%";//字符串截取
            }
	   }
	   if(!$_POST){/**大家都在买,推荐位**/
	       $this->assign('list',$data);// 赋值数据集
           $this->assign('maxnum',$res['pagenum']);// 赋值数据集
          return $this->fetch();

        }else{
        
		 //AJAX刷新数据
            return $data;
        }
		
	}
       /* 团购列表页 */
    public function tuan($id = 0, $p = 1){			
		/*内容页统计代码实现，status=2*/
		if(1==C('IP_TONGJI')){
		   $record=IpLookup("",2,$id);
		}
        $map['status']=1; 
        $page = input('p')?input('p'):1;
        $id = input('id',0,'intval');
        /* 分类信息 */
		//$Categorys=new \app\wap\model\Category;
		$category["id"] = $id;
        /* 模板赋值并渲染模板 */
	    $this->assign('category', $category);
        
       	$key=input('order');
		$key=safe_replace($key);//过滤
		$sort=input('sort');  
        $sort=safe_replace($sort);//过滤
		if($key){ 
		   if(!is_numeric($key)){
		         $this->error('排序ID错误！');
		   }
		   switch ($key) { 
		        case '1': 
				    $listsort="view"." ".$sort;
                break;
				case '2':
				   $listsort="id"." ".$sort;
                  break;				
			   case '3': 
				   $listsort="price"." ".$sort;
                  break;
                case '4':                    
				   $listsort="sales"." ".$sort;
					 break;              
		   }  	
	   } 
	   else {
		 $key="2";
		 $see="asc";
		 $order="view";
		 $sort="asc";
		 $listsort=$order." ".$sort;			
	   }
		
       if($sort=="asc"){
		  $see="desc";
	   }
       if($sort=="desc"){
		  $see="asc";
	   }
	   $categorys['id']=$id;
       $this->assign("cate", $categorys);
	  
       $this->assign('see',$see);
       $this->assign('order',$key);
	   $this->assign('value',$sort);
	   $Goods=new \app\wap\model\Goods;
       $res= $Goods->getLists($id,$listsort,$map,$page,6);
       $data = $res['list'];
	   if(!$_POST){/**大家都在买,推荐位**/
	      $this->assign('list',$data);// 赋值数据集
          $this->assign('maxnum',$res['page']['num']);// 赋值数据集
          return $this->fetch();

        }else{
         //ajax 刷新数据
            foreach($data as &$vo){
               $vo['image'] = get_cover($vo['cover_id'],'path');
               $vo['url'] = U('goods/detail?id='.$vo['id']);
               $vo['title'] = substr_cn($vo['title']);//字符串截取
               
            }
		 //AJAX刷新数据
            return $data;
        }
		
	}

  /* 商品列表页 */
    public function search($id = 0, $p = 1){			
		
        $keyword= input('keyword');//获取分类的英文名称
        $keyword=safe_replace($keyword);//过滤
		if($keyword){
		  session('keyword',null);
          session('keyword',$keyword);
		}
        else{
		   session('keyword',$keyword);
		}
        $words=session('keyword');
        $map['title']  = array('like','%'.$words.'%');
        $map['status']=1; 
        $p= input('p')?input('p'):1;
        $id = input('pid',0,'intval');
       	$key=input('order');
		$key=safe_replace($key);//过滤
		$sort=input('sort');  
        $sort=safe_replace($sort);//过滤
		if($key){ 
		   if(!is_numeric($key)){
		         $this->error('排序ID错误！');
		   }
		   switch ($key) { 
		        case '1': 
				    $listsort="view"." ".$sort;
                break;
				case '2':
				   $listsort="id"." ".$sort;
                  break;				
			   case '3': 
				   $listsort="price"." ".$sort;
                  break;
                case '4':                    
				   $listsort="sale"." ".$sort;
					 break;              
		   }  	
	   } 
	   else {
		 $key="2";
		 $see="asc";
		 $order="view";
		 $sort="asc";
		 $listsort=$order." ".$sort;			
	   }
		
       if($sort=="asc"){
		  $see="desc";
	   }
       if($sort=="desc"){
		  $see="asc";
	   }
       $this->assign('pid',$id);
       $this->assign('see',$see);
       $this->assign('order',$key);
	   $this->assign('value',$sort); 
	   $field = 'id,price,title,category_id,view,cover_id,sales,comments';
       $res=  apiLists('goods',$map,"10","id desc",$p,$field);
       $data = $res['list']?$res['list']:"";
	   $cate["id"]=0;
	   if(input('keyword')){/**大家都在买,推荐位**/
	      $this->assign('cate',$cate);// 赋值数据集
		  $this->assign('list',$data);// 赋值数据集
          $this->assign('maxnum',$res['pagenum']);// 赋值数据集
          return $this->fetch( );

        }else{
         //ajax 刷新数据
		  if($data){
				foreach($data as &$vo){
				   $vo['image'] = get_cover($vo['cover_id'],'path');
				   $vo['url'] = U('goods/detail?id='.$vo['id']);
				   $vo['title'] = substr_cn($vo['title']);//字符串截取
				 
				}
			}
		 //AJAX刷新数据
           return $data;  
        }
		
	}

  //详情页
     public function detail($id){
		
		if(!is_numeric($id)){
		         $this->error('id错误！');
		 }
		$map["id"]=$id;
		$map["status"]=1;//正常上架的商品
		$info=db('goods')->where($map)->find();
	
		if(!$info){
		      $this->error('商品不存在！');
		}
		db('goods')->where($map)->setInc("view");
	    $this->assign("info",$info);

		//分类
		$cate_id=$info["category_id"];
		
		 /*商品规格列表筛选*/
		 if($info["specs"]){
			unset($map);
			$cate=db("category")->find($cate_id);
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
            //dump($attrlist);
			$this->assign("attrlist",$attrlist);

		}
        //库存
		$map2['goods_id']=$id;
	    //sku列表
        $sku2=db("sku")->where($map2)->field("title,num,goods_id,price")->find();
		$this->assign('sku2',$sku2);
		
		//评论列表
		$comment=getAjaxLists("comment",$map2,"10","id desc");
		foreach ($comment["list"] as &$v) {
                $v['pictures']= explode(",",$v['cover_id']);
				$v['username']= get_username($v['uid']);
        }
		$comment["count"]=db("comment")->where($map2)->count(); 
		$map2['is_over']=1;
		$comment["is_over_count"]=db("comment")->where($map2)->count();
		unset($map2);
		$map2['goods_id']=$id;
		//$map2['is_picture']=1;
		$comment["is_picture_count"]=db("comment")->where($map2)->count();
		$this->assign('comment',$comment);

		//判断是否收藏
		if(is_login()){
           unset($map);
           $map['uid']=is_login(); 
		   $map['goods_id']=$id;
		   $is_collect=db("collect")->where($map)->find();
		   $this->assign('is_collect',$is_collect);

		}
	     //浏览记录
		if(session("log")){
			  if(in_array($id,session("log"))==false){
			     $arr=session("log");
				 array_push($arr,$id);
				 session("log",$arr);
			   }
			}
		else{
		  $arr=array();
		  array_push($arr,$id);
		  session("log",$arr);
			
		}
	
		return $this->fetch();
			
	}

	  //分享页
     public function comment($id){
	    
		 if(!is_numeric($id)){
		         $this->error('id错误！');
		 }
		$map["goods_id"]=$id;
       


		$p= input('p')?input('p'):1;
	    $res=  apiLists('comment',$map,"10",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				
				   $vo['create_time'] =  date("Y-m-d h:i",$vo['create_time']);//时间
				    $vo['html'] = '<div class="de_con04_m">	
					<div class="de_con04_tip">
						<div class="de_con04_tip_l fl"><div class="star'.$vo['score'].'"></div></div>
						<div class="de_con04_tip_m fl">'.get_username($vo['uid']).'</div>
						<div class="de_con04_tip_r fr">'.$vo['create_time'].'</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="de_con04_b">'.$vo['message'].'</div>';
				}
			}
	    if(!$_POST){/**大家都在买,推荐位**/
			$comment["count"]=db("comment")->where($map)->count(); 
			$map["status"]=1;
			$comment["count2"]=db("comment")->where($map)->count(); 
			unset($map["status"]);
			$map["status"]=2;
			$comment["count3"]=db("comment")->where($map)->count(); 
			unset($map["status"]);
			$map["status"]=["gt",2];
            $comment["count4"]=db("comment")->where($map)->count();
		    $this->assign('comment',$comment);// 赋值数据集
		    $this->assign('list',$data);// 赋值数据集
            $this->assign('maxnum',$res['pagenum']);// 赋值数据集
            return $this->fetch( );
        }else{
		 
		 //AJAX刷新数据
           return $data;  
        }
			
	}


     //分享页
     public function share($id){
	    
		 if(!is_numeric($id)){
		         $this->error('id错误！');
		 }
		$map["id"]=$id;
		$map["status"]=1;//正常上架的商品
		$info=db('goods')->where($map)->find();
	
		if(!$info){
		      $this->error('商品不存在！');
		}
		db('goods')->where($map)->setInc("view");
	    
		$param["id"]=$info['id'];
        $param["uid"]=is_login();
        $info["url"]=root_url().url('goods/detail',$param);
		$this->assign("info",$info);
		return $this->fetch();
			
	}
   private function category($id = 0){
		/* 标识正确性检测 */
		$id = $id ? $id : input('get.pid', 0);
		if(empty($id)){
		$this->error('没有指定文档分类！');
		}
		/* 获取分类信息 */ 
		$Category=new \app\wap\model\Category;
		$category = $Category->info($id);
		if($category && 1 == $category['status']){
			switch ($category['display']) {
				case 0:
				$this->error('该分类禁止显示！');
				break;
				//TODO: 更多分类显示状态判断
				default:
				return $category;
			}
		}
		else {
		   $this->error('分类不存在或被禁用！');
		}
	} 
}
