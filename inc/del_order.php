<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$delid = $_POST['delid'];
if($delid)
{
   //$sql = "delete from  e_order  where order_no = '$delid'";
   if( delete('e_order_mac',' id='.$delid) > 0){
       echo 'go';
    } 
}

?>