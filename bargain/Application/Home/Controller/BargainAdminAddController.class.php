<?php
namespace Home\Controller;
use Think\Controller;
class BargainAdminAddController extends Controller {
    public function _initialize(){
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Methods: GET, POST, PUT');
    }
	    // 管理员注册接口  http://master.echao.com/bargain/index.php/Home/BargainAdminAdd/AddAdmin
    public function AddAdmin(){  

        $bargain_admin = M("bargain_admin");

        $create = array(
            "company_name"  => I("post.company_name"),
            "phone"  => I("post.phone"),
            "password"  => I("post.password"),
            "recommender"  =>  addslashes(I("post.recommender")),
            "province" => I("post.province"),
            "industry" => I("post.industry"),
            "city" => I("post.city"),
            "start_time" => date("Y/m/d H:i:s",time()),
            "end_time" => date("Y/m/d H:i:s",time()),
            "addtime" => time(),
            "ip" => get_client_ip()
        );
        // 手机是否注册过此网站
        $where = array( "phone"  => $create['phone'] );

        $data  = $bargain_admin->where($where)->find();

        if( $data ){

            $this->ajaxReturn('no');

        }else{

            if( $res = $bargain_admin -> add($create) ){

               $create["id"] = $res;

               $this->ajaxReturn($create);

            }else{

               $this->ajaxReturn('新增失败');

            }     
        }
    }
    // 用户登录
    public function login(){  
      
        $bargain_admin = M("bargain_admin");

        $login_arr = array( 
            "phone" => I("post.phone"),
            "password" => I("post.password"),
        );

        $user = $bargain_admin->where( array( "phone" => $login_arr['phone'] ) )->find();

        if( $user ){

            $user_login = $bargain_admin->where( $login_arr )->find();

        if( $user_login ){

            $this->ajaxReturn(array("user"=>$user_login,"status"=>"ok"));

          }else{

            $this->ajaxReturn(array("user"=>'手机号或密码错误！',"status"=>"no"));

          }

        }else{

            $this->ajaxReturn(array("user"=>'手机号或密码错误！',"status"=>"no"));
            
        }
    }   
}