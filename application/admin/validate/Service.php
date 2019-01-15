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
namespace app\admin\validate;
use think\Validate;
use think\Db;
/**
 * 客服服务验证器
 */
class Service  extends Validate{

	protected $rule = [
        'title'  =>  'require|max:225',
		'type'  =>  'require|max:225',
		'content'  => 'require|max:225',
        
    ];

    protected $message = [
        'title.require'  =>  '标题必须',
        'type.require'  =>  '类型必须',
		'content.require'  => '内容必须',
    ];

    protected $scene = [
        'add'   =>  ['title','type','content'],
        'edit'  =>  ['title','type','content'],
    ];  
}
