<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$delid = $_POST['delid'];
   if( delete('ppt_upload','id='.$delid) > 0 ){
     echo "go";
   }

?>