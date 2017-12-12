<?php
namespace Home\Controller;
use Think\Controller;
class BargainAddUserController extends Controller {
    public function _initialize(){
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Methods: GET, POST, PUT');
    }
	    // 为用户添加砍价活动
    public function AddUser(){  

        $Bargain_user = M("Bargain_user");
        $bargain = M("bargain");
        $create = array(
          "openid"  => I("post.openid"),
          "username"  => I("post.username"),
          "phone_number"  => I("post.phone_number"),
          "bargain_id" => I("post.bargain_id"),
          "original_price" => I("post.original_price"),
          "floor_price" => I("post.floor_price"),
          "new_price" => I("post.new_price"),
          "address" => I("post.address"),
          "bargain_type" => 2,
          "bargain_times" => 9999,
          "ip" => get_client_ip(),
          "addtime" => time(),
        );
        $where = array( "phone_number"  => $create['phone_number'],"openid"  => $create['openid'], "bargain_id" => $create['bargain_id']);
        $data  = $Bargain_user->where($where)->find();
        // 参加活动的时候加一人次
        $bargain_data = $bargain-> where( array("id" => $create['bargain_id']) )->find();
        $arr = array(
          "user_cj" => $bargain_data['user_cj']+1
          );
        if( $data ){
          $this->ajaxReturn('你已经参加了此活动');
        }else{
          if( $res = $Bargain_user -> add($create) ){
             $row = $bargain->where( array("id" => $create['bargain_id']) )->save($arr);
             $create["id"] = $res;
             $this->ajaxReturn($create);
          }else{
             $this->ajaxReturn('新增失败');
          }     
        }
    }  
}