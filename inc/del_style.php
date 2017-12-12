<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$delid = $_POST['delid'];
$uid = $_SESSION['uid'];
$sql = "select id,style_no from e_goods_sylte where id=".$delid;
$res = fetchOne($sql)['style_no'];

if( $delid ){
	if( delete('e_goods_sylte','id='.$delid) ){
		if( $res ){
			if( delete('e_goods_list','style_no='.$res) ){
	        	echo "go"; 
	     	}else{
		   		echo "go";
			}
		}
	 }
} 

?>