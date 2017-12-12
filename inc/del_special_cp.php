<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$delid = $_POST['delid'];
if($delid)
{
  $row = mysql_query("delete from e_user_zt_goods where id='$delid' ");
   if( $row ){
      echo "go";
   }
}

?>