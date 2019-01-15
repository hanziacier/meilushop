<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
use think\Db;


function  getEqual($id){
	$map['goods_id']=$id;
	$list=Db::name("comment")->where($map)->select();
	
	if(!$list){
	  return 0;
	}
	$count=Db::name("comment")->where($map)->count();
	$total="";
	foreach($list as $k=>$v){
	 $total+=$v["des"];
	}
    return ceil($total/$count);  
}
function  getmaxnum($id){
	$map['id']=$id;
	$count=Db::name("goods")->where($map)->value("pin_max_num");
	
	
	
	$map2['goods_id']=$id;$map2['status']=1;
	$num=Db::name("order")->where($map2)->count();
    if(!$num){
	   $n= $count-1;
	}
	if($num&$count>$num){
	    $n=$count-$num; 
	} 
	if($n>0){
		return $n;
	}
	return 0;
    
}
 function get_place($id){
    
         $info0 = db('Category')->find($id);
		 $Lever_1='<li class="subnav"><a href="'.url('goods/lists',array('id'=>$id)).'">'.$info0['title'].'</a>'.parse($id).'</li><li> &gt; </li>';
		 if(!$info0['pid']){
           return $Lever_1;
		 }
		//2级分类，第2级	 
         $pid=$info0['pid'];
		 $info=db('Category')->where("id='$pid'")->find();
		 //设置链接
		 $Lever_2='<li class="subnav"><a href="'. url('goods/lists',array('id'=>$pid)).'">'.$info['title'].'</a>'.parse($pid).'</li><li> &gt; </li>';
		// 获取当前分类的上级分类主键id
		 $pid2=$info['pid'];
		 if(!$pid2){
            return $Lever_2.$Lever_1;		
		 }
		 $info3=db('Category')->where("id='$pid2'")->find();
		 if(isset($info3)){//判断是否是一级分类,获取标题和标识
			  $info2=db('Category')->where("id='$pid2'")->find();
			 //设置链接
			  $href_3=url('goods/lists',array('id'=>$pid2));
			  $Lever_3='<li class="subnav"><a href="'.$href_3.'">'.$info2['title'].'</a>'.parse($pid2).'</li><li> &gt; </li>';
			  return $Lever_3.$Lever_2.$Lever_1;
		 
		 }
	
}
 function get_list($id){
    
         $info0 = db('Category')->find($id);
		 $Lever_1='<li class="subnav"><a href="'.url('goods/lists',array('id'=>$id)).'">'.$info0['title'].'</a>'.parse($id).'</li>';
		 if(!$info0['pid']){
           return $Lever_1;
		 }
		//2级分类，第2级	 
         $pid=$info0['pid'];
		 $info=db('Category')->where("id='$pid'")->find();
		 //设置链接
		 $Lever_2='<li class="subnav"><a href="'. url('goods/lists',array('id'=>$pid)).'">'.$info['title'].'</a>'.parse($pid).'</li><li> &gt; </li>';
		// 获取当前分类的上级分类主键id
		 $pid2=$info['pid'];
		 if(!$pid2){
            return $Lever_2.$Lever_1;		
		 }
		 $info3=db('Category')->where("id='$pid2'")->find();
		 if(isset($info3)){//判断是否是一级分类,获取标题和标识
			  $info2=db('Category')->where("id='$pid2'")->find();
			 //设置链接
			  $href_3=url('goods/lists',array('id'=>$pid2));
			  $Lever_3='<li class="subnav"><a href="'.$href_3.'">'.$info2['title'].'</a>'.parse($pid2).'</li><li> &gt; </li>';
			  return $Lever_3.$Lever_2.$Lever_1;
		 
		 }
	
}

function parse($id){
       $list=db('Category')->where("pid='$id'")->select();
	  
                     $htm='<div class="drop">
								<dl>';
								
								
								foreach($list as $k=>$v){
	 $htm.='<dd><a href="'.url('goods/lists',array('id'=>$v['id'])).'">'.$v['title'].'</a></dd>';
	}								
									
							$htm.=	'</dl>
							</div>';
   return $htm;
   
}

function get_category_title($id){
   
	$map['id']=$id;
	$info=Db::name("category")->where($map)->find();
    return $info['title'];  
}	

function get_price($id){
    $groupbuying=Db::name("stock");
	$map['goods_id']=$id;
	$info=$groupbuying->where($map)->find();
    return $info['price']?$info['price']:0;  
}

function get_mprice($id){
    $groupbuying=Db::name("stock");
	$map['goods_id']=$id;
	$info=$groupbuying->where($map)->find();
    return $info['mprice']?$info['mprice']:0;  
}
