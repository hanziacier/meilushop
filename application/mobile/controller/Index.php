<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\mobile\Controller;
use think\Db;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 $url= $_SERVER[HTTP_HOST]; //获取当前域名  
 */
class Index extends Home{
 

	/**系统首页**/
    public function index(){
    			// cookie自动登录
		if(!is_login()&&cookie('username')&&cookie('password')){
		    $username=cookie('username'); 
            $password=cookie('password'); 
            $username =safe_replace($username);//过滤
			$key=config('database.key');
			 /* 调用UC登录接口登录 */
			 $map["password"]=ucenter_md5($password, $key);
			 $map["username"]=$username;
			 $user =db('UcenterMember')->where($map)->find();
			 if($user['status']>0){
			  $uid = $user["id"];
			      $user=new \app\common\model\User; 
			      $user->send($uid);
		    }
       }
	        	 
	 //幻灯片
	    $slidelist=lists("slide","","10","id desc");
	    $this->assign('slidelist',$slidelist);

		//首页商品推荐
        $tree=model("category")->maketree( ) ;
		$this->assign ( 'tree', $tree );

        unset($map);
        $time=date('H',time());
		if($time>=10&&$time<15){$end=date('Y/m/d',time())." 15:00:00";  $where['category_id']=167;}
		if($time>=15&&$time<20){$end=date('Y/m/d',time())." 20:00:00";  $where['category_id']=168;}
		if($time>=20&&$time<22){$end=date('Y/m/d',time())." 22:00:00";  $where['category_id']=168;}
        if($time>=22&&$time<24){$end=date('Y/m/d',time())." 23:59:59";  $where['category_id']=170;}
        if($time>=0&&$time<10){$end=date('Y/m/d',time())." 9:59:59";  $where['category_id']=171;}
		$this->assign('time',$time);
		$this->assign('end',$end);
            $map["status"]=1;
	    $goodslist=lists("goods",$map,"10","id asc");
	    $this->assign('goodslist',$goodslist);

		$this->meta_title = '首页';		
		 return $this->fetch();
	}

	/**客服**/
    public function activity(){
    

		
        $map=''; 
	 
		$this->meta_title = '我的收藏';
      
		$p= input('p')?input('p'):1;
	    $res=  apiLists('reduction',$map,"6",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				   $vo['image'] = get_goods_cover($vo['id']);
				   $url = url('activity/lists?id='.$vo['id']);
				   $src=get_cover_path($vo['cover_id']);  
				   $start_time=time_format($vo['start_time']); 
				   $end_time=time_format($vo['end_time']);
			
				
				    $vo['html'] = '<li>
						<div class="ac_con01_img">
							<a href="'.$url.'"><img src="'.$src.'" /></a>
							<div class="ac_con01_data_bg"></div>
							<div class="ac_con01_data">'.$start_time.' — '.$end_time.'</div>
							
						</div>
						<div class="ac_con01_text">购物金额满'.$vo['total'].'元，省'.$vo['total_money'].'元</div>

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
  
	/**客服**/
    public function tuan(){
    

		    $map['status']=1; 
		
        $p= input('p')?input('p'):1;
      
	    $res=  apiLists('goods',$map,"6",'id desc',$p);
      
       $data = $res['list'];if($data){
				foreach($data as &$vo){
					$url=url('goods/detail?id='.$vo['id']);
					$src=get_cover_path($vo['cover_id']);
					$title=substr_cn($vo['title']);
				    $vo['html'] = '<li>
		   			<div class="sc_con01_close04"><a href="'.$url.'">立即抢购</a></div>
		   			<div class="sc_con01_img"><a href="'.$url.'"><img src="'.$src.'"/></a></div>
		   			<div class="sc_con01_text">
		   				<div class="sc_con01_t"><a href="'.$url.'">'.$title.'</a></div>
<div class="sc_con01_pri">￥'.$vo['price'].'元<span>￥'.$vo['price'].'元</span></div>
<div class="sc_con01_cc">销量：'.$vo['sales'].'</div>
		   			</div>
		   		</li>';
				 
				}
		}
	   if(!$_POST){/**大家都在买,推荐位**/
	      $this->assign('list',$data);// 赋值数据集
           $this->assign('maxnum',$res['pagenum']);// 赋值数据集
          return $this->fetch();

        }else{
         
            return $data;
        }	
		
	} 	/**客服**/
    public function shouji(){
    
            $map['category_id']=176; 
		    $map['status']=1; 
		
        $p= input('p')?input('p'):1;
      
	    $res=  apiLists('goods',$map,"6",'id desc',$p);
      
       $data = $res['list'];if($data){
				foreach($data as &$vo){
					$url=url('goods/detail?id='.$vo['id']);
					$src=get_cover_path($vo['cover_id']);
					$title=substr_cn($vo['title']);
				    $vo['html'] = '<li>
		   			<div class="sc_con01_close04"><a href="'.$url.'">手机购</a></div>
		   			<div class="sc_con01_img"><a href="'.$url.'"><img src="'.$src.'"/></a></div>
		   			<div class="sc_con01_text">
		   				<div class="sc_con01_t"><a href="'.$url.'">'.$title.'</a></div>
<div class="sc_con01_pri">￥'.$vo['price'].'元</div>
<div class="sc_con01_cc">销量：'.$vo['sales'].'</div>
		   			</div>
		   		</li>';
				 
				}
		}
	   if(!$_POST){/**大家都在买,推荐位**/
	      $this->assign('list',$data);// 赋值数据集
           $this->assign('maxnum',$res['pagenum']);// 赋值数据集
          return $this->fetch();

        }else{
         
            return $data;
        }	
		
	} 
   public function score(){ 
	   $map['status']=1; 
        $map['category_id']=173; 
	 
		$this->meta_title = '我的收藏';
      
		$p= input('p')?input('p'):1;
	    $res=  apiLists('goods',$map,"6",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				   $vo['image'] = get_goods_cover($vo['id']);
				   $vo['url'] = url('score/add?id='.$vo['id']);
				   
			
				
				    $vo['html'] = '<li class="item">
						<div class="in_con03_main">
							<div class="in_con03_img">
								<a href="'.$vo['url'].'"><img src="'.$vo['image'].'" /></a>
							</div>
							<div class="in_con03_text">
								<a href="'.$vo['url'].'">'.$vo['title'].'</a>
							</div>
							<div class="in_con03_pri">'.$vo['score'].'积分</div>
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
  public function shan(){ 
	     $map['status']=1;
		 $map['category_id']=174; 
      
		$p= input('p')?input('p'):1;
	    $res=  apiLists('goods',$map,"10",'id desc',$p);
        $data = $res['list']?$res['list']:"";
		if($data){
				foreach($data as &$vo){
				   $vo['image'] = get_goods_cover($vo['id']);
				   $vo['url'] = url('goods/detail?id='.$vo['id']);
				   $vo['score']='';
			       if($vo['end_time']<=time()){
			         $vo['url']='javascript:vod(0)';
					 $vo['name']='已结束';
			       }else{
				     $vo['name']='立即闪购';

				   }
				
				    $vo['html'] = '<li>
						<div class="sg_con01_img"><a href="'.$vo['url'].'"><img src="'.$vo['image'].'"/></a></div>
						<div class="sg_con01_m">
							<div class="sg_con01_text">'.$vo['title'].'</div>
							<div class="sg_con01_pri">￥'.$vo['price'].'<span>￥'.$vo['price'].'</span></div>
							<div class="sg_con01_time">距结束还有<span class="endtime" value="'.$vo['end_time'].'"></span>
</div>
						<div class="sc_con01_close04 sg_con01_btn"><a href="'.$vo['url'].'">'.$vo['name'].'</a></div>
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
		 return $this->fetch();
	} 
	public function get($time){
	date_default_timezone_set("Asia/Shanghai");
    $time2 =time();
    $second = $time - $time2;
	$day = floor($second/(3600*24));
	$second = $second%(3600*24);
	$hour = floor($second/3600);
	$second = $second%3600;
	$minute = floor($second/60);
	$second = $second%60;
   if($day>0){
      return '<span>'.$day.'</span>天<span>'.$hour.'</span>时<span>'.$minute.'</span>分<span>'.$second.'</span>秒';
   }else{
     return '<span>0</span>天<span>0</span>时<span>0</span>分<span>0</span>秒';
   }

  
	
	}
  public function sign() {
		if ( !is_login() ) {
			 $this->error("请先登录","User/login" );
		}
        $uid=is_login();
        $map['id']=$uid;
		$res= db('ucenterMember')->where($map)->setInc('score',10);
		if($res){
		      $this->success("签到成功！");
		}else{
			   
			 $this->error("签到失败！");
	     }  
	}  
   
}