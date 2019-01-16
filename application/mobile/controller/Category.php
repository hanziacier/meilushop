<?php
// +----------------------------------------------------------------------
// | Yershop 开源网店系统
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.yershop.com All rights reserved.
// +----------------------------------------------------------------------
namespace app\mobile\controller;
use think\Db;
/**
 * 取消订单模型控制器
 * 文档模型列表和详情
 */
class Category extends Home {

     /* 商品分类 */
    public function index(){ 		
          /**垂直菜单**/
		$category=model( 'Category' )->getCategory() ;
		$this->assign('category', $category);	
		$this->meta_title = '分类';
		 return $this->fetch();
    }

   public function lists(){
        
		$this->meta_title = '品质保障';
        $this->display();

    }	  
}
