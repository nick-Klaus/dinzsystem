<?php
namespace Home\Controller;
use Think\Controller;
class BargainPayLogController extends Controller {
    public function _initialize(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT');
    }
	// 管理员注册接口  http://master.echao.com/bargain/index.php/Home/BargainPayLog/pay_list
    public function pay_list(){
        $adminid = I("post.adminid");

        $admin_data = M("bargain_admin")->where( array( "id" => $adminid ) ) -> find();
        // 支付完成后回调链接
        $_url = urlencode("http://master.echao.com/bargain/index.php/Home/BargainPayLog/pay_add");
        // 支付时间 和令牌生成时间 
        $new_time = time();
        // 支付单号
        $order_300 = "PAY300-".$adminid;
        // 支付令牌 字母必须为大写
        $token300 = md5($new_time.md5("300".$order_300.$new_time));
        // 支付单号
        $order_1000 = "PAY1000-".$adminid;
        // 支付令牌
        $token1000 = md5($new_time.md5("1000".$order_1000.$new_time));

        $this->ajaxReturn( array( "admin" => $admin_data,"_url"=>$_url,"token300"=>$token300,"token1000"=>$token1000, "time" => $new_time,"order_300" => $order_300,"order_1000" => $order_1000) );
    }
    // 支付完成后添加日 和修改时间
    public function pay_add(){  
        // @file_put_contents( dirname(__FILE__)."/temp0001.json", json_encode(array($_POST)) );
        $bargain_admin = M("bargain_admin");
        $order_no = $_POST['order_on'];
        $fee = intval($_POST['fee'])/100;
        $adminid = explode('-',$order_no);
        $where = array( "id" => $adminid[1] );
        $admin_data = $bargain_admin->where($where) -> find();
        // 结束时间大于当前是间 为续费
        $now_time = time();
        $end_time = strtotime($admin_data['end_time']);
        // old_time  存在则加到新的时间中
        $old_time = $end_time-$now_time;

        if( $old_time >= 0 ){
            $old_time = $old_time;
        }else{
            $old_time = 0;
        }

        $array = array(
            "start_time" => date("Y/m/d H:i:s",$now_time),
            );

        // 支付一个月的时间
        if( $adminid[0] == "PAY300" && $fee == "300"){
            $pay_type = 2;
            $new_end = ($now_time+30*24*3600)+$old_time;
            $array['end_time'] = date("Y/m/d H:i:s",$new_end);
            $res = $bargain_admin-> where( $where )-> save( $array );
        }
        // 支付一年的时间
        if( $adminid[0] == "PAY1000" && $fee == "1000"){
            $pay_type = 1;
            $new_end = ($now_time+365*24*3600)+$old_time;
            $array['end_time'] = date("Y/m/d H:i:s",$new_end);
            $res = $bargain_admin-> where( $where )-> save( $array );
        }
        // 添加日志
        $creat = array(
            "company_id" => $adminid[1],
            "pay_price" => $fee,
            "pay_type" => $pay_type,
            "pay_time" => date("Y/m/d H:i:s",$now_time),
            );
        M("bargain_pay_log")->add( $creat );
    }

    // 砍价支付定金
    public function pay_deposit(){
        // @file_put_contents( "./Public/temp0001.json", json_encode(array($_POST)) );
        $bargain_user = M("bargain_user");
        $order_no = $_POST['order_on'];
        $fee = intval($_POST['fee'])/100;
        $adminid = explode('-',$order_no);// 获取用户的id
        $where = array( "id" => $adminid[1] );
        $user_data =  $bargain_user->where($where) -> find();// 获取用户的详细信息
        $bargain_data =  M("bargain")->where(array("id"=>$user_data['bargain_id'])) -> find();// 获取活动的详细信息
        // 支付金额和 活动的定金相等才改变状态
        if( $bargain_data['pay_deposit'] == $fee ){
            $log_arr = array(
                "company_id" => $adminid[1],
                "pay_price" => $fee,
                "pay_type" => 3,
                "bargain_id" =>$bargain_data['id'],
                "pay_time" => date("Y/m/d H:i:s",time())
            );
            $pay_status = array("pay_status"=>1);
            $num = $bargain_user->where( $where )-> save( $pay_status ); // 修改支付状态
            @file_put_contents( "./Public/temp0001.json", json_encode(array($num)) );
            if( $num ){
                M("bargain_pay_log")->add($log_arr);// 添加日志
            }
        }
    }
    // 支付日志
    public function pay_list_all(){ 

        $res = M("bargain_pay_log")-> where(array( "company_id" => I("post.adminid") ))->order("id desc")->select();

        $this->ajaxReturn( $res );
    }
}