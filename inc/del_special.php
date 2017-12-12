<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid'];
$delid = $_POST['delid'];
if($delid)
{
   if( delete('e_user_zt','id='.$delid) > 0){
         $where = " ztid='$delid' and adduid='$uid'";
   		$sql = "select * from e_user_zt_goods where ".$where;
   		if(count(fetchAll($sql)) > 0){
   			 if( delete('e_user_zt_goods', $where ) > 0 ){
	   		 	echo 'go';
	   		 }  
   		}else{
   			echo 'go';
   		}
   		   
    } 
   		
}

?>