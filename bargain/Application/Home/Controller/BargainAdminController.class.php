<?php
namespace Home\Controller;
use Think\Controller;
class BargainAdminController extends Controller {
    public function _initialize(){
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Methods: GET, POST, PUT');
    }
    //  管理员详细信息http://master.echao.com/bargain/index.php/Home/BargainAdmin/adminmsg
    public function adminmsg(){

        $bargain_admin = M("bargain_admin");

        $bargain = M("Bargain");

        $admin_id = I("post.adminid");

        $status = I("post.status");
        // 管理员活动的详细信息 4为全部活动
        if( $status == 4 ){
            $where = "a.openid=b.openid and a.admin_id=".$admin_id;
        }else{
            $where = "a.openid=b.openid and a.admin_id=".$admin_id." and a.status=".$status;
        }
        $bargain_data = $bargain-> where( $where )->join( "a left join bargain_user b on a.id=b.bargain_id" )-> order('a.id desc' )->field("a.*,b.id as userid")-> select();
        // 获取管理员详细信息
        $adminmsg = $bargain_admin-> where( array( "id" => $admin_id ) )->find();

        $bargain_count = $bargain-> where( array( "admin_id" => $admin_id ) )->count();

        $this->ajaxReturn( array( "bargain"=> $bargain_data, "admin"=> $adminmsg, "count"=> $bargain_count ) );
    }

    // 参加活动人的详细信息
    public function userlist(){

        $bargain_user = M("bargain_user");

        $username = I("post.username");

        if( $username ){
            $where = array( "bargain_id" => I("post.bargain_id"), "username" => $username );    
        }else{
            $where = array( "bargain_id" => I("post.bargain_id") );
        }

        $user_data = $bargain_user-> where( $where )->select();

        $this->ajaxReturn( $user_data );
    }

    // 参加活动的人是否兑换奖品
    public function user_update_status(){

        $bargain_user = M("bargain_user");

        $where = array( "id" => I("post.user_id") );

        $update = array( "status" => I("post.status") );
        
        $user_data = $bargain_user-> where( $where )->save($update);

        $this->ajaxReturn( $user_data );
    }
    // 把活动下架
    public function bargain_update_status(){
        $bargain = M("bargain");

        $where = array( "id" => I("post.id") );

        $update = array( "status" => I("post.status") );
        
        $bargain_data = $bargain-> where( $where )->save($update);

        $this->ajaxReturn( $bargain_data );
    }

}