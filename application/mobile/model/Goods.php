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
namespace app\mobile\model;
use think\Model;
use think\Db;
/**
 * 文档基础模型
 */
class Goods extends Model{

 
   public function getList(){
        //属性
		$attrs=Db::name('goods')->select();
		return  $attrs;
    }

   public function getLists($cate_id,$order,$map,$page = 1,$num =6){
        $field = 'id,price,title,category_id,view,cover_id,sales,comments';
        //查询属于cate_id （包含其子分类的商品）
		$Category=new \app\mobile\model\Category;
        $cid =  $Category->getChildrenId($cate_id);
            //查询商品并分类处理
        $map['category_id'] = array('in',$cid);
        $data['count'] = db('goods')->where($map)->count();
        $data['num'] = ceil($data['count']/$num);
        $result =db('goods')->where($map)->field($field)->order($order)->page($page,$num)->select();
        $res['list'] = $result;
        $res['page'] = $data;
        return $res;
    }
}
