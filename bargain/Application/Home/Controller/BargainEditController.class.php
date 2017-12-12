<?php
namespace Home\Controller;
use Think\Controller;
class BargainEditController extends Controller {
    public function _initialize(){
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Methods: GET, POST, PUT');
	  }
    // 查询出要修改的活动  
    public function editlist(){
        $res = M("bargain")->where( array( "id"=>I("post.bargainid") ) )->find();
        $res['gift_describe'] = json_decode($res['gift_describe'])?json_decode($res['gift_describe']):array();
        $res['company_introduction_img'] = json_decode($res['company_introduction_img'])?json_decode($res['company_introduction_img']):array();
        $this->ajaxReturn( $res );
    }    

	// 修改砍价活动
    public function editcontent(){
        $id = I("post.id");
        $bargain_user = M("bargain_user");
        $create = array(
            "image_logo"  => I("post.onlyimg"),
            "title" => I("post.title"), 
            "start_time"  => date("Y/m/d H:i:s",strtotime( I("post.start_time") )),
            "end_time"  => date("Y/m/d H:i:s",strtotime( I("post.end_time") )),
            "original_price"  => I("post.original_price"),
            "floor_price"  => I("post.floor_price"),
            "bargain_times"  => I("post.bargain_times"),
            "min_sale"  => I("post.min_sale"),
            "max_sale"  => I("post.max_sale"),
            "new_gift_quantity"  => I("post.gift_quantity"),//添加的礼品剩余数量等于
            "gift_quantity"  => I("post.gift_quantity"),
            "gift_describe"  => json_encode(I("post.gift_describe"),true),
            "gift_describe_txt"  => I("post.gift_describe_txt"),
            "max_people"  => I("post.max_people", "intval"),
            "activity_rules"  => I("post.activity_rules"),
            "award_information"  => I("post.award_information"),
            "company_introduction"  => I("post.company_introduction"),
            "company_introduction_img"  => json_encode(I("post.company_introduction_img"),true),
            "phone_number"  => I("post.phone_number"),
        );
        $create_user = "";
        $old_original_price = I("post.old_original_price");
        $old_floor_price = I("post.old_floor_price");
        $user_row = $bargain_user->where( array( "bargain_id"=>$id,"openid"=>I("post.openid") ) )->select();
        if( !is_array( $user_row) || !$id ){
            $this->ajaxReturn( "修改的用户不存在！" );
            exit;
        }
        // 只修改底价
        if( $old_floor_price != $create['floor_price'] && $old_original_price == $create['original_price'] ){
            foreach ($user_row as $k => $v) {
                // 用户已经砍到底价修改底价 则现价也一起修改
                if( $v['new_price'] == $v['floor_price'] || $v['new_price'] < $create['floor_price'] ){
                    $create_user['new_price'] = $create['floor_price'];
                }
                $create_user['floor_price'] = $create['floor_price'];
                $num_user = $bargain_user ->where( array( "bargain_id"=>$id ) )-> save($create_user);
            }
        }
        // 只修改原价
        if( $old_floor_price == $create['floor_price'] && $old_original_price != $create['original_price'] ){

            foreach ($user_row as $k => $v) {
                if( $v['new_price'] > $create['original_price'] ){
                    $create_user['new_price'] = $create['original_price'];
                }
                $create_user['original_price'] = $create['original_price'];
                $num_user = $bargain_user ->where( array( "bargain_id"=>$id ) )-> save($create_user);
            }
        }

        // 原价和底价同时修改
        if( $old_floor_price != $create['floor_price'] && $old_original_price != $create['original_price'] ){

            foreach ($user_row as $k => $v) {
                // 修改的原价小于现价 则现价改为 修改过的原价
                if( $v['new_price'] > $create['original_price'] ){
                    $create_user['new_price'] = $create['original_price'];
                }
                // 用户已经砍到底价修改底价 则现价也一起修改
                if( $v['new_price'] == $v['floor_price'] || $v['new_price'] < $create['floor_price'] ){
                    $create_user['new_price'] = $create['floor_price'];
                }
                $create_user['original_price'] = $create['original_price'];
                $create_user['floor_price'] = $create['floor_price'];
                $num_user = $bargain_user ->where( array( "bargain_id"=>$id ) )-> save($create_user);
            }
        }
        if( $id ){
            $res = M("Bargain")->where(array("id"=>$id)) -> save($create);
            $this->ajaxReturn( $res );
        }
    }

    // 活动时间到则结束活动 修改状态为 2
    public function editstatus(){
        $bargainid = I("post.bargainid");
        $array = array( "status" => I("post.status") );
        if( $bargainid ){
            $num = M("bargain")->where( array( "id"=> $bargainid ) )->save( $array );
            $this->ajaxReturn( $num );
        }
    }
}