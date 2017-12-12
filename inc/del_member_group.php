<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$delid = $_POST['delid'];

if( $delid ){
	if( delete('e_fx_group','id='.$delid) > 0 ){
		delete('e_member_group_zk','group_id='.$delid);
	    $sql = "select * from e_fx_members where groupid=".$delid;
	    if( count(fetchAll($sql)) > 0 ){
	    	if( delete('e_fx_members','groupid='.$delid) > 0 ){
	    		echo 'go';
	    	}		
	    }else{
	    	echo 'go';
	    }  
	}
}

?>