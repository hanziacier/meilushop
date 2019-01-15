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
namespace app\admin\model;
use think\Model;
use think\Db;
/**
 * 满减优惠模型
 */
class Reduction extends Model{

      protected $auto = ["start_time","end_time","uid"];
     protected $insert = ["start_time","end_time","uid"];  
     protected $update = ["start_time","end_time","uid"];  
     protected function setStartTimeAttr()
    {
		
		return strtotime(input('start_time'));
		
    }
	protected function setUidAttr()
    {
		
		return is_login();
		
    }
	  protected function setEndTimeAttr()
    {
		
		return  strtotime(input('end_time'));
		
    }


}
