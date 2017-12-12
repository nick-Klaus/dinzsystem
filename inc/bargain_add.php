<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$id = $_POST['id'];
$sql = "select * from bargain where id='$id'";
$res = fetchOne( $sql );
$res['user_cj'] = 0;
$res['user_fx'] = 0;
$res['user_ck'] = 1;
$res['user_floor'] = 0;
unset($res['id']);
if( $id ){ 
	if( $bargain_id = insert($res,'bargain') ){
		$sql_user = "select * from bargain_user where bargain_id='$id' and openid='".$res['openid']."'";
		$res_user = fetchOne( $sql_user );
		unset($res_user['id']);
		$res_user['new_price'] = $res['original_price'];
		$res_user['bargain_id'] = $bargain_id;
		if( insert($res_user,'bargain_user') ){
			echo "ok";
		}
	}
 }

?>