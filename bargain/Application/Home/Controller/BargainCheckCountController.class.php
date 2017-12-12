<?php
namespace Home\Controller;
use Think\Controller;
class BargainCheckCountController extends Controller {
    public function _initialize(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT');
    }
	  // 添加砍价活动的日志
    public function index(){  
        $bargain_check_count = M("bargain_check_count");
        $bargain = M("bargain");
        $creat = array( 
            "openid" => I("post.openid"),
            "user_id" => I("post.user_id"),
            "bargain_id" => I("post.bargain_id"),
            "addtime" => time(),
            "ip" => get_client_ip()
        );
        $bargain_data = $bargain-> where( array("id" => $creat['bargain_id']) )->find();
        $user_ck = $bargain_data['user_ck']?$bargain_data['user_ck']:1;
        $arr = array(
            "user_ck" => $user_ck+1
        );
        if( $res = $bargain_check_count-> add( $creat ) ){
            if( $user_ck ){
                $row = $bargain->where( array("id" => $creat['bargain_id']) )->save($arr);
            }
            $this->ajaxReturn(array("success" =>$res,"text" => "添加日志成功","row"=>$row ));
        }else{
            $this->ajaxReturn("添加日志失败");
        }
     
    }
     // 添加砍价活动的分享次数
    public function fxtimes(){  
          $bargain = M("bargain");
          $bargain_id = I("post.bargain_id");
          $bargain_data = $bargain-> where( array("id" => $bargain_id) )->find();
          $arr = array( "user_fx" => $bargain_data['user_fx']+1 );
          if( $row = $bargain->where( array("id" => $bargain_id) )->save($arr) ){
              $this->ajaxReturn(array("success" =>$row,"text" => "添加日志成功" ));
          }else{
              $this->ajaxReturn("添加日志失败");
          }
        }
}