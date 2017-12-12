<?php
include "../fun/eby_admin_api.php";
include "../fun/phpfile.php";

// 需要全部修改的活动id
$sql = "select * from t_diamondsystem.bargain_user where bargain_id='389'";
$res = fetchAll($sql);

foreach ($res as $k => $v) {
	// 日志库里查询出 对应活动的 用户最低价格
	$_sql = "select user_id,openid,min(new_price) from t_diamondsystem.bargain_log where bargain_id='389' and user_id='".$v['id']."'";
 	$_res = fetchOne($_sql);
 	 
 	$array = array( 
 		"new_price" => $_res['min(new_price)']
  	);

 	$user_id =  $_res['user_id'];
   // 恢复用户的最低价
 	// if( $user_id ){

 	// 	var_dump( update($array,'bargain_user',"id='$user_id'") );

 	// }
 	 
}




 


?>