<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$delid = $_POST['delid'];
if( $delid ){
    if( delete('e_mac_service','id='.$delid) > 0){
            echo 'go';     
    }
}



?>