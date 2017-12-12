<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$delid = $_POST['delid'];

if( $delid  ){
   if( delete('bargain_template','id='.$delid) > 0 ){
     echo "go1";
   }
}

// 删除活动 和 活动用户
$bargainid = $_POST['bargainid'];

if( $bargainid  ){
   if( delete('bargain','id='.$bargainid ) > 0 ){
   		$user = delete('bargain_user','bargain_id='.$bargainid );
    	echo "go1";
   }
}


?>