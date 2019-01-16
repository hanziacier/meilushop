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
namespace app\mobile\controller;
use think\Controller;
use think\Db;
/*购物车*/
class Account extends Home{
	
	public function index() {
		  $meta_title = '余额管理';
		
	      return $this->fetch();
		
	}
	/*账户消费明细*/
	public function lists(){
		if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		
		$uid=is_login();
		$this->meta_title = '我的积分';
        $map['uid']=$uid;//用户id
		//$map['type']=1;//用户id
		$p= input('p')?input('p'):1; 
	    $res=  apiLists('AccountLog',$map,"20",'id desc',$p);
        $data = $res['list']?$res['list']:"";
	
		if($data){
				foreach($data as &$vo){
                   $vo['pay_url'] = url('pay/edit?id='.$vo['id']);
				   $vo['del_url'] = url('del?id='.$vo['id']);
				   $vo['create_time'] =  date("Y-m-d h:i",$vo['create_time']);//时间

				   $vo["html"]='<tr>
                                
									<td>'.$vo['id'].' </td>
									<td>'.$vo['money'].' </td>
			                     
									<td> '.$this->parse($vo['status']).'
									 </td>
					                <td>'.$vo['create_time'].' </td>
			                      </tr>';
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
	 public function parse($status){   
	       switch ($status)
				{
				case 0:
				  return "消费";
				  break;
				case 1:
				  return "充值";
				  break;
				case 2:
				  return "取现";
				  break;
				default:
				  return  "消费";
				}
	}
	public function out() {

        if ($_POST) {
		    $total_money=safe_replace(input('total_money'));
			if(!$total_money){
				$this->error('金额不能为空');//订单禁止提交
			}
			$uid=is_login();
            
			 ///消减会员账户
		     $u["id"]=$uid;
			 $UcenterMember=db("UcenterMember"); 
		     $in=$UcenterMember->where($u)->find(); 
			 if($in["account"]<$total_money){
			    $this->error('余额不足');//订单禁止提交
			 }
			 $save["account"]=$in["account"]-$total_money;
			 $UcenterMember->where($u)->field("account")->update($save);
			
			//余额变化记录
		     $save2["uid"]=$uid;
             $save2["type"]=2;//取现
			 $save2["money"]=$total_money;//金额
			 $save2["create_time"]=time();
			 $save2["content"]="提现";
			 $save2["total"]=$save["account"];//提现后剩余金额
             db("account_log")->insert($save2); 
		     unset($save2);
             //取现申请
		     $save2["uid"]=$uid;
             $save2["status"]=0;//提交申请
			 $save2["total_money"]=$total_money;//金额
			 $save2["create_time"]=time();
			 $save2["content"]=safe_replace(input('content'));
             db("cash")->insert($save2); 


		 }else{
			   return $this->fetch();	
			
		 }
	} 
	public function add() {

        if ($_POST) {
		    $money=safe_replace(input('money'));
			if(!$money){
				$this->error('金额不能为空');//货到付款订单禁止提交
			}
            $type=input('type'); 
		    /* 标识正确性检测 */
		    if(!( $type && is_numeric( $type))){
		       $this->error('充值方式错误！');
		    }
		   //支付宝支付
            if($type==1){
			   $param['money'] = $money;
			   $this->redirect('Alipay/add', $param);
			
			}
	        else if($type==2){
				
				$uid=is_login();
                $out_trade_no=$this->ordersn();//创建订单号 
				//保存支付信息
			    $data["out_trade_no"]= $out_trade_no;
			    $data["total_money"]=$money;
			    $data["uid"]=$uid;
			    $data["model"]="account";
				$data["type"]=1;
			    $id=db("pay")->insertGetId($data);
			    $param['id'] = $id;
			    $this->redirect('pay/wxpay', $param);
			}
			else{
			    $this->error('充值方式错误！');
			}


		 }else{
			   return $this->fetch();	
			
		 }
	}   // 生成支付订单号
   public function ordersn(){
        if ( is_login() ) {
		      $uid=is_login();
		      $code=date('Ymd',time()).time().$uid;
	       return $code;
		}
    }  

	/*余额消费明细*/
	public function logs(){
		if(!is_login() ) {
			$this->error( "您还没有登陆",url("User/login") );
		}
		
		$uid=is_login();
		$this->meta_title = '我的积分';
        $map['uid']=$uid;//用户id
		$p= input('p')?input('p'):1; 
	    $res=  apiLists('cash',$map,"20",'id desc',$p);
        $data = $res['list']?$res['list']:"";
	
		if($data){
				foreach($data as &$vo){
                   $vo['pay_url'] = url('pay/edit?id='.$vo['id']);
				   $vo['del_url'] = url('del?id='.$vo['id']);
				   $vo['create_time'] =  date("Y-m-d",$vo['create_time']);//时间

				   $vo["html"]='<div class="sqjl_con01_main">
				<div class="sqjl_con01_t">'.$vo['create_time'].'<span>'.$this->parse($vo['status']).'</span></div>
				<div class="sqjl_con01_m">账户充值<span>￥'.$vo['money'].'元</span></div>
				<div class="sqjl_con01_b">管理员备注：<span>'.$vo['remark'].'</span></div>
				<div class="sqjl_con01_tx">提现账号：'.$vo['content'].'</div>
				
			</div>';
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
	 public function parse2($status){   
	       switch ($status)
				{
				case 0:
				  return "未确认";
				  break;
				case 1:
				  return "已转账";
				  break;
				case 2:
				  return "已拒绝";
				  break;
				default:
				  return  "未确认";
				}
	}

}
