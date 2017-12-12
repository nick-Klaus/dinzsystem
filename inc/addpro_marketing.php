<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$uid = $_POST['adduid'];

$service_type = isset($_POST['service_type'])?1:0;
if( $uid ){
    $arr = array(
     'service_tit'  => $_POST['service_tit'],
     'introduce'    => $_POST['introduce'],
     'service_logo' => $_POST['service_logo'],
     'service_url'  => $_POST['service_url'],
     'adduid'       => $uid,
     'service_page' =>$_POST['service_page'],
     'service_type' => $service_type,
    );
}
    if( insert($arr,'e_mac_service') ){
        echo 'go';
    }

?>