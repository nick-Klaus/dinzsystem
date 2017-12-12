<?php
namespace Home\Controller;
use Think\Controller;
class BargainTemplateController extends Controller {
    public function _initialize(){
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Methods: GET, POST, PUT');
    }
	    // 管理员注册接口  http://master.echao.com/bargain/index.php/Home/BargainTemplate/template_list
    public function template_list(){  

        $template_data = M("bargain_template") -> select();
        
        $this->ajaxReturn(  $template_data );
    }
}