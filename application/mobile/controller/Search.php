<?php
namespace app\mobile\controller;
use think\Controller;
/**
* 文档模型控制器
* 文档模型列表和详情
*/
class  Search extends Home {

	public function index(){
		
		
		$this->meta_title = '搜索';
     
        return $this->fetch( );
     
		
	}
    public function lists(){
		
		
		$keyword=input('keyword');//获取分类的英文名称
        $keyword=safe_replace($keyword);//过滤
		$array["title"]=$keyword;
		$array["key"]=session('key')?session('key'):rand(1,100).time();
		if($keyword&&!db("keyword")->where($array)->select()){
		   $array["create_time"]=time();
		   $array["uid"]=is_login()?is_login():0;
		   db("keyword")->insert($array);
		}
		if($array["key"]){
		  session('key',$array["key"]);
         
		}
        
      			$keyword= input('keyword');//获取搜索内容
		$keyword=safe_replace($keyword);//过滤
		
		$map['title']  = array('like','%'.$keyword.'%');
        $map['status']=1; //dump($map);
        $page =input('p')?input('p'):1;
        $pid =input('pid',0,'intval');
		if($pid){
			$map['category_id']=$pid;
		}
		
		$p= input('p')?input('p'):1;
		$order=input('order')?input('order'):3;
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
       $this->assign('order',$order);
	   $this->assign('see',$see);//dump($map);
	    $res=apiLists('goods',$map,"10",$listsort,$p);
        $data = $res['list']?$res['list']:"";
		 if($data){
				foreach($data as &$vo){
					$url=url('article/detail?id='.$vo['id']);
					$src=get_cover_path($vo['cover_id']);
					$title=substr_cn($vo['title']);
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
           return $this->fetch( );
        }else{
		 
		 //AJAX刷新数据
           return $data;  
        }
		return $this->fetch();
    }
 		/**商品分类菜单调用**/
    public function getCategory(){
	    
			$field = 'id,pid,title,sort,model_id';
			$map["type"]=1;
			$map["status"]=1;
			$Category =db( 'Category' )->where($map)->field($field)->order('sort asc,id asc')->select( );
			$list = $this->unlimitedForLevel($Category);
			return $list;
		} 
		
	public function unlimitedForLevel($cate,$name = 'child',$pid = 0){
		$arr = array( );
		foreach ( $cate as $key => $v ) {
		//判断，如果$v['pid'] == $pid的则压入数组Child
		    if ($v['pid'] == $pid) {
			//递归执行
			$v[$name] = self::unlimitedForLevel($cate,$name,$v['id']);
			$arr[] = $v;
		    }
		}
		return $arr;
	}
	public function clear(){
		$array["key"]=session('key');
		if(db("keyword")->where($array)->select()){
		   $array["uid"]=is_login()?is_login():0;
		   $data["status"]=0;
		   $recent=db("keyword")->where($array)->update($data);
          
		}
	}
	
	/**商品分类菜单调用**/
       public function change(){
		    $id=safe_replace(input("id"));
			$n=safe_replace(input("n"))+1;
			$ids=model('category')->getChildren($id);
			$map["pid"]=$id;
			$map["type"]=1;
			$map["status"]=1;
			$field = 'id,pid,title,sort,model_id';
			$data =db( 'Category' )->where($map)->field($field)->order('sort asc,id asc')->select( );	
			$where["pid"]=["in",$ids];
			   if(db( 'Category' )->where($where)->select()){
					foreach($data as &$vo){
							$vo['html'] = '<a onclick="change('.$vo["id"].','.$n.')">'.$vo["title"].'</a>';
					}
					
			    }
				else{
					foreach($data as &$vo){
						  $vo['html'] = '<a onclick="setpid('.$vo["id"].')">'.$vo["title"].'</a>';
					}
				}
				
				return $data?$data:'';
		} 
}
