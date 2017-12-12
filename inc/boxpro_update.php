<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

//改变微信上级ID 配置
$id = $_POST['id'];
$m_uid = $_POST['m_uid'];
$arr = array(
    'wei_uid'=>$_POST['wei_uid'],
    'mac_logo'=>$_POST['mac_logo'],
    'uid'=>$_POST['uid'],
    'eby_weixin'=>$_POST['eby_weixin'],
    'mac_remark'=>$_POST['mac_remark'],
    'user_remark'=>$_POST['user_remark'],
    'startTime'=>strtotime($_POST['startTime']),
    'endTime'=>strtotime($_POST['endTime'])
    );
$_arr = array(
    'wechat_picture'=>$_POST['wechat_picture'],
    'alipay_picture'=>$_POST['alipay_picture'],
    );
if( $m_uid ){
	if( update($_arr,'e_members','uid='.$m_uid) ){
		echo "go";
	}
}
if( $id ){
	if( update($arr,'e_mac_code','id='.$id) ){
	    echo "go";
	    exit;
	}
}


//改变设备的状态 重置按钮
$delid = $_POST['delid'];
$array = array( 'yznum'=>$_POST['state'] );
if( $delid ){
	if( update($array,'e_mac_code','id='.$delid) ){
	    echo "go1";
	    exit;
	}
}



?>